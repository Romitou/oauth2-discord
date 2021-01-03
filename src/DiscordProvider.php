<?php

namespace Romitou\OAuth2\Client;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class DiscordProvider extends AbstractProvider
{

    use BearerAuthorizationTrait;

    const DISCORD_API = 'https://discord.com/api/v8';
    const DISCORD_CDN = 'https://cdn.discordapp.com/avatars';

    /**
     * Returns the base URL for authorizing a client.
     * https://discord.com/api/v{api_version}/oauth2/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return self::DISCORD_API . '/oauth2/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     * https://discord.com/api/v{api_version}/oauth2/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return self::DISCORD_API . '/oauth2/token';
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string
     */
    public function getScopeSeparator(): string
    {
        return ' ';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     * https://discord.com/api/v{api_version}/users/@me
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return self::DISCORD_API . '/users/@me';
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return ['identify'];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string $data Parsed response data
     * @return void
     * @throws DiscordProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400)
            throw new DiscordProviderException($response->getReasonPhrase(), $response->getStatusCode(), $response);
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new DiscordRessourceOwner($response);
    }
}