<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration\v1p0;

use GrotonSchool\LTI\Registration\PropertyCollectionTrait;
use GrotonSchool\LTI\Registration\UniqueArrayValuesTrait;
use GrotonSchool\LTI\Registration\ValidateUriTrait;
use JsonSerializable;

class LtiConfiguration implements JsonSerializable
{
    use PropertyCollectionTrait;
    use UniqueArrayValuesTrait;
    use ValidateUriTrait;

    public const DOMAIN = 'domain';
    public const SECONDARY_DOMAINS = 'secondary_domains';
    public const DEPLOYMENT_ID = 'deployment_id';
    public const TARGET_LINK_URI = 'target_link_uri';
    public const CUSTOM_PARAMETERS = 'custom_parameters';
    public const DESCRIPTION = 'description';
    public const MESSAGES = 'messages';
    public const CLAIMS = 'claims';

    /**
     * The primary domain covered by this tool; protocol must not be included. For example mytool.example.org
     */
    protected ?string $domain = null;
    public function setDomain(string $domain)
    {
        // TODO validate domain is domain
        $this->domain = $domain;
        return $this;
    }
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * (optional)
     * Array of domains also covered by this tool
     * @var string[]
     */
    protected ?array $secondary_domains = null;
    public function setSecondaryDomains(array $secondary_domains)
    {
        foreach ($secondary_domains as $secondary_domain) {
            $this->addSecondaryDomain($secondary_domain);
        }
        return $this;
    }
    public function addSecondaryDomain(string $secondary_domain)
    {
        return $this->addUnique($secondary_domain, self::SECONDARY_DOMAINS);
    }
    public function getSecondaryDomains()
    {
        return $this->secondary_domains;
    }

    /**
     * (optional)
     * In the case where a platform is combining registration and deployment of a tool, the platform may pass the LTI deployment_id associated with this client registration's deployment.
     */
    protected ?string $deployment_id = null;
    public function setDeploymentId(string $deployment_id)
    {
        $this->deployment_id = $deployment_id;
        return $this;
    }
    public function getDeploymentId()
    {
        return $this->deployment_id;
    }

    /**
     * The default target link uri to use unless defined otherwise in the message or link definition.
     */
    protected ?string $target_link_uri = null;
    public function setTargetLinkUri(string $target_link_uri)
    {
        $this->validateUri($target_link_uri);
        $this->target_link_uri = $target_link_uri;
        return $this;
    }
    public function getTargetLinkUri()
    {
        return $this->target_link_uri;
    }

    /**
     * (optional)
     * JSON Object where each value is a string. Custom parameters to be included in each launch to this tool. If a custom parameter is also defined at the message level, the message level value takes precedence. The value of the custom parameters may be substitution parameters as described in the LTI Core [LTI-13](https://www.imsglobal.org/spec/lti-dr/v1p0#bib-lti-13) specification.
     * @var array<string,string>
     */
    protected ?array $custom_parameters = null;
    public function setCustomParameters(array $custom_parameters)
    {
        foreach ($custom_parameters as $name => $value) {
            $this->setCustomParameter($name, $value);
        }
        return $this;
    }
    public function setCustomParameter(string $parameterName, string $value)
    {
        $this->custom_parameters[$parameterName] = $value;
        return $this;
    }
    public function getCustomParameters()
    {
        return $this->custom_parameters;
    }

    /**
     * (optional)
     * A short plain text description of the tool. Localized representations may be included as described in Section 2.1 of the [OIDC-Reg] specification.
     */
    protected ?string $description = null;
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * An array of messages supported by this tool. See below for message properties.
     * @var LtiMessage[]
     */
    protected ?array $messages = null;
    /**
     * @param LtiMessage[] $messages
     */
    public function setMessages(array $messages)
    {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }
        return $this;
    }
    public function addMessage(LtiMessage $message)
    {
        $this->messages[] = $message;
        return $this;
    }
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * An array of claims indicating which information this tool desire to be included in each `idtoken`. The tool should be explicit about identity claims such as `sub`, `given_name`, ... It should omit LTI claims when the inclusion of those is driven by the message definition.
     * @var string[]
     */
    protected ?array $claims = null;
    /**
     * @param string[] $claims
     */
    public function setClaims(array $claims)
    {
        foreach ($claims as $claim) {
            $this->addClaim($claim);
        }
        return $this;
    }
    public function addClaim(string $claim)
    {
        return $this->addUnique($claim, self::CLAIMS);
    }
    public function getClaims()
    {
        return $this->claims;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            switch ($propertyName) {
                case self::DOMAIN:
                    $this->setDomain($value);
                    break;
                case self::SECONDARY_DOMAINS:
                    $this->setSecondaryDomains($value);
                    break;
                case self::DEPLOYMENT_ID:
                    $this->setDeploymentId($value);
                    break;
                case self::TARGET_LINK_URI:
                    $this->setTargetLinkUri($value);
                    break;
                case self::CUSTOM_PARAMETERS:
                    $this->setCustomParameters($value);
                    break;
                case self::DESCRIPTION:
                    $this->setDescription($value);
                    break;
                case self::MESSAGES:
                    $this->setMessages($value);
                    break;
                case self::CLAIMS:
                    $this->setClaims($value);
                    break;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            ...$this->requiredProperties([
                self::DOMAIN,
                self::TARGET_LINK_URI,
                self::MESSAGES,
                self::CLAIMS
            ]),
            ...$this->optionalProperties([
                self::SECONDARY_DOMAINS,
                self::DEPLOYMENT_ID,
                self::CUSTOM_PARAMETERS,
                self::DESCRIPTION
            ])
        ];
    }
}
