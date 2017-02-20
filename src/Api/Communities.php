<?php

namespace TwitchApi\Api;

use TwitchApi\Exceptions\EndpointNotSupportedByApiVersionException;
use TwitchApi\Exceptions\InvalidEmailAddressException;
use TwitchApi\Exceptions\InvalidParameterLengthException;
use TwitchApi\Exceptions\InvalidTypeException;

trait Communities
{
    /**
     * Get community by name
     *
     * @param string $name
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCommunityByName($name)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($name)) {
            throw new InvalidTypeException('Name', 'string', gettype($name));
        }

        return $this->get('communities', ['name' => $name]);
    }

    /**
     * Get community by ID
     *
     * @param string $id
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getCommunityById($id)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($id)) {
            throw new InvalidTypeException('ID', 'string', gettype($id));
        }

        return $this->get(sprintf('communities/%s', $id));
    }

    /**
     * Create a community
     *
     * @param string $name
     * @param string $summary
     * @param string $description
     * @param string $rules
     * @param string $accessToken
     * @throws InvalidParameterLengthException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function createCommunity($name, $summary, $description, $rules, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (strlen($name) < 3 || strlen($name) > 25) {
            throw new InvalidParameterLengthException('name');
        }

        if (strlen($summary) > 160) {
            throw new InvalidParameterLengthException('summary');
        }

        if (strlen($description) > 1572864) { // 1.5MB
            throw new InvalidParameterLengthException('description');
        }

        if (strlen($rules) > 1572864) { // 1.5MB
            throw new InvalidParameterLengthException('rules');
        }

        $params = [
            'name' => $name,
            'summary' => $summary,
            'description' => $description,
            'rules' => $rules,
        ];

        return $this->post('communities', $params, $accessToken);
    }

    /**
     * Update a community
     *
     * @param string $communityId
     * @param string $accessToken
     * @param string $summary
     * @param string $description
     * @param string $rules
     * @param string $email
     * @throws InvalidParameterLengthException
     * @throws EndpointNotSupportedByApiVersionException
     * @throws InvalidEmailAddressException
     * @return array|json
     */
    public function updateCommunity($communityId, $accessToken, $summary = null, $description = null, $rules = null, $email = null)
    {
        $params = [];

        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if ($summary) {
            if (strlen($summary) > 160) {
                throw new InvalidParameterLengthException('summary');
            }
            $params['summary'] = $summary;
        }

        if ($description) {
            if (strlen($description) > 1572864) { // 1.5MB
                throw new InvalidParameterLengthException('description');
            }
            $params['description'] = $description;
        }

        if ($rules) {
            if (strlen($rules) > 1572864) { // 1.5MB
                throw new InvalidParameterLengthException('rules');
            }
            $params['rules'] = $rules;
        }

        if ($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new InvalidEmailAddressException();
            }
            $params['email'] = $email;
        }

        return $this->put(sprintf('communities/%s', $communityId), $params, $accessToken);
    }

    /**
     * Get top communities
     *
     * @param int    $limit
     * @param string $cursor
     * @throws InvalidLimitException
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getTopCommunities($limit = 10, $cursor = null)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('Cursor', 'string', gettype($cursor));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
        ];

        return $this->get('communities/top', $params);
    }

    /**
     * Get banned community users
     *
     * @param string $communityId
     * @param string $accessToken
     * @param int    $limit
     * @param string $cursor
     * @throws InvalidLimitException
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function getBannedCommunityUsers($communityId, $accessToken, $limit = 10, $cursor = null)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!$this->isValidLimit($limit)) {
            throw new InvalidLimitException();
        }

        if ($cursor && !is_string($cursor)) {
            throw new InvalidTypeException('Cursor', 'string', gettype($cursor));
        }

        $params = [
            'limit' => intval($limit),
            'cursor' => $cursor,
        ];

        return $this->get(sprintf('communities/%s/bans', $communityId), $params, $accessToken);
    }

    /**
     * Ban a community user
     *
     * @param string $communityId
     * @param string $userId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function banCommunityUser($communityId, $userId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        return $this->put(sprintf('communities/%s/bans/%s', $communityId, $userId), [], $accessToken);
    }

    /**
     * Un-ban a community user
     *
     * @param string $communityId
     * @param string $userId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return array|json
     */
    public function unbanCommunityUser($communityId, $userId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        return $this->delete(sprintf('communities/%s/bans/%s', $communityId, $userId), [], $accessToken);
    }

    /**
     * Upload a community avatar image (600x800px)
     *
     * @param string $communityId
     * @param string $avatar (base64 encoded)
     * @param string $accessToken
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return null|array|json
     */
    public function createCommunityAvatar($communityId, $avatar, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($avatar)) {
            throw new InvalidTypeException('Avatar', 'string', gettype($avatar));
        }

        return $this->post(sprintf('communities/%s/images/avatar', $communityId), ['avatar_image' => $avatar], $accessToken);
    }

    /**
     * Delete a community avatar image
     *
     * @param string $communityId
     * @param string $accessToken
     * @throws EndpointNotSupportedByApiVersionException
     * @return null|array|json
     */
    public function deleteCommunityAvatar($communityId, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        return $this->delete(sprintf('communities/%s/images/avatar', $communityId), [], $accessToken);
    }

    /**
     * Upload a community cover image (1200x180px)
     *
     * @param string $communityId
     * @param string $image (base64 encoded)
     * @param string $accessToken
     * @throws InvalidTypeException
     * @throws EndpointNotSupportedByApiVersionException
     * @return null|array|json
     */
    public function createCommunityCoverImage($communityId, $image, $accessToken)
    {
        if (!$this->apiVersionIsGreaterThanV4()) {
            throw new EndpointNotSupportedByApiVersionException('communities');
        }

        if (!is_string($image)) {
            throw new InvalidTypeException('Cover image', 'string', gettype($image));
        }

        return $this->post(sprintf('communities/%s/images/cover', $communityId), ['cover_image' => $image], $accessToken);
    }
}