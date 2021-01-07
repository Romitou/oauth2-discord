<?php

namespace Romitou\OAuth2\Client;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class DiscordRessourceOwner implements ResourceOwnerInterface
{

    private array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->response['id'];
    }

    /**
     * Returns the username of the authorized resource owner.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->response['username'];
    }

    /**
     * Returns the complete username of the authorized resource owner, including his discriminator.
     * It is built with : <username>#<discriminator>.
     *
     * @return string|null
     */
    public function getCompleteUsername(): ?string
    {
        if ($this->getUsername() == null || $this->getDiscriminator() == null) return null;
        return $this->getUsername() . '#' . $this->getDiscriminator();
    }

    /**
     * Returns the avatar URL of the authorized resource owner.
     * It is built with the resource owner's identifier and the hash of his avatar.
     *
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        if ($this->getId() == null || $this->getAvatarHash() == null) return null;
        return DiscordProvider::DISCORD_CDN . '/' . $this->getId() . '/' . $this->getAvatarHash() . '.png';
    }

    /**
     * Returns the avatar hash of the authorized resource owner.
     *
     * @return string|null
     */
    public function getAvatarHash(): ?string
    {
        return $this->response['avatar'];
    }

    /**
     * Returns the discriminator of the authorized resource owner.
     *
     * @return string|null
     */
    public function getDiscriminator(): ?string
    {
        return $this->response['discriminator'];
    }

    /**
     * Returns the flags of the authorized resource owner.
     *
     * @return int|null
     */
    public function getPublicFlags(): ?int
    {
        return $this->response['public_flags'];
    }

    /**
     * Returns the flags of the authorized resource owner.
     *
     * @return int|null
     */
    public function getFlags(): ?int
    {
        return $this->response['flags'];
    }

    /**
     * Returns the email of the authorized resource owner.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->response['email'];
    }

    /**
     * Returns the email verification status of the resource owner.
     *
     * @return bool|null
     */
    public function isVerified(): ?bool
    {
        return $this->response['verified'];
    }

    /**
     * Returns the locale of the resource owner.
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->response['locale'];
    }

    /**
     * Returns the 2FA status of the resource owner.
     *
     * @return bool|null
     */
    public function hasMfaEnabled(): ?bool
    {
        return $this->response['mfa_enabled'] === true;
    }

    /**
     * Returns	the type of Nitro subscription of the resource owner.
     * 0: None
     * 1: Nitro Classic
     * 2: Nitro
     *
     * @return int|null
     */
    public function getPremiumType(): ?int
    {
        return $this->response['premium_type'];
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}