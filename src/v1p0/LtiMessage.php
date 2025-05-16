<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration\v1p0;

use GrotonSchool\LTI\Registration\PropertyCollectionTrait;
use GrotonSchool\LTI\Registration\UniqueArrayValuesTrait;
use GrotonSchool\LTI\Registration\ValidateUriTrait;
use JsonSerializable;

class LtiMessage implements JsonSerializable
{
    use PropertyCollectionTrait;
    use UniqueArrayValuesTrait;
    use ValidateUriTrait;

    public const TYPE = 'type';
    public const TARGET_LINK_URI = 'target_link_uri';
    public const LABEL = 'label';
    public const ICON_URI = 'icon_uri';
    public const CUSTOM_PARAMETERS = 'custom_parameters';
    public const PLACEMENTS = 'placements';
    public const ROLES = 'roles';

    public const TYPE_RESOURCE_LINK = 'LtiResourceLinkRequest';

    /**
     * The message type
     */
    protected string $type = self::TYPE_RESOURCE_LINK;
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
    public function getType()
    {
        return $this->type;
    }

    /**
     * (optional)
     * Target link uri to apply when launching this message. If not present, the tool's `target_link_uri` defined above apply.
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
     * A label a platform may apply to decorate that link. Localized representations may be included as described in Section 2.1 of the [OIDC-Reg] specification.
     */
    protected ?string $label = null;
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * (optional)
     * An icon the platform may apply to decorate the link.
     */
    protected ?string $icon_uri = null;
    public function setIconUri(string $icon_uri)
    {
        $this->validateUri($icon_uri);
        $this->icon_uri = $icon_uri;
        return $this;
    }
    public function getIconUri()
    {
        return $this->icon_uri;
    }

    /**
     * (optional)
     * JSON Object where each value is a string. Custom parameters to be included in each launch to this tool using this message. If a custom parameter is also defined at the tool level, the message level value takes precedence. As per LTI Core [LTI-13](https://www.imsglobal.org/spec/lti-dr/v1p0#bib-lti-13) Specification, when the value of a substitution parameter starts with a $, it indicates the use of a substitution parameter.
     * @var array<string,string>
     */
    protected ?array $custom_parameters = null;
    public function setCustomParameters(array $custom_parameters)
    {
        foreach ($custom_parameters as $parameterName => $value) {
            $this->addCustomParameter($parameterName, $value);
        }
        return $this;
    }
    public function addCustomParameter(string $name, string $value)
    {
        $this->custom_parameters[$name] = $value;
        return $this;
    }
    public function getCustomParameters()
    {
        return $this->custom_parameters;
    }

    /**
     * (optional)
     * Array of placements indicating where the platform should add links for this message when this tool is made available, if it supports those placements. The platform may choose other placements as well but the tool signals primary support for placements in this list first and foremost.
     * @var string[]
     */
    protected ?array $placements = null;
    /**
     * @param string[] $placements
     */
    public function setPlacements(array $placements)
    {
        foreach ($placements as $placement) {
            $this->addPlacement($placement);
        }
        return $this;
    }
    public function addPlacement(string $placement)
    {
        return $this->addUnique($placement, self::PLACEMENTS);
    }
    public function getPlacements()
    {
        return $this->placements;
    }

    /**
     * (optional)
     * Array of fully qualified roles as defined in LTI 1.3 Core that are allowed to launch this message. A user only needs to match one of the listed roles. A tool should always properly handle unexpected roles since there is no requirement for the platform to enforce the roles restriction, or it may persist under a less granular classification (for example, learner or not learner). The role property is useful when the type of the message, possibly coupled with its placement, is not already naturally tailoring access to a message to a given set of users of the platform.
     * @var string[]
     */
    protected ?array $roles = null;
    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
        return $this;
    }
    public function addRole(string $role)
    {
        return $this->addUnique($role, self::ROLES);
    }
    public function getRoles()
    {
        return $this->roles;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            switch ($propertyName) {
                case self::TYPE:
                    $this->setType($value);
                    break;
                case self::TARGET_LINK_URI:
                    $this->setTargetLinkUri($value);
                    break;
                case self::LABEL:
                    $this->setLabel($value);
                    break;
                case self::ICON_URI:
                    $this->setIconUri($value);
                    break;
                case self::CUSTOM_PARAMETERS:
                    $this->setCustomParameters($value);
                    break;
                case self::PLACEMENTS:
                    $this->setPlacements($value);
                    break;
                case self::ROLES:
                    $this->setRoles($value);
                    break;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            ...$this->requiredProperties([self::TYPE]),
            ...$this->optionalProperties([
                self::TARGET_LINK_URI,
                self::LABEL,
                self::ICON_URI,
                self::CUSTOM_PARAMETERS,
                self::PLACEMENTS,
                self::ROLES
            ])
        ];
    }
}
