<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration\Instructure\Canvas;

use GrotonSchool\LTI\Registration\EnumeratedArrayValuesTrait;
use GrotonSchool\LTI\Registration\v1p0;

class LtiConfiguration extends v1p0\LtiConfiguration
{
    use EnumeratedArrayValuesTrait;

    public const PRIVACY_LEVEL = 'https://canvas.instructure.com/lti/privacy_level';
    public const TOOL_ID = 'https://canvas.instructure.com/lti/tool_id';
    public const VENDOR = 'https://canvas.instructure.com/lti/vendor';

    public const PRIVACY_PUBLIC = 'public';
    public const PRIVACY_NAME_ONLY = 'name_only';
    public const PRIVACY_EMAIL_ONLY = 'email_only';
    public const PRIVACY_ANONYMOUS = 'anonymous';

    public const PRIVACY_LEVELS = [
        self::PRIVACY_PUBLIC,
        self::PRIVACY_NAME_ONLY,
        self::PRIVACY_EMAIL_ONLY,
        self::PRIVACY_ANONYMOUS
    ];

    /**
     * (optional)
     * The tool's default privacy level, (determines the PII fields the tool is sent.) defaults to "anonymous"
     * @var string "public" | "name_only" | "email_only" | "anonymous"
     */
    protected string $privacy_level = 'anonymous';
    public function setPrivacyLevel(string $privacy_level)
    {
        $this->validateEnumeratedValues($privacy_level, self::PRIVACY_LEVELS);
        $this->privacy_level = $privacy_level;
        return $this;
    }
    public function getPrivacyLevel()
    {
        return $this->privacy_level;
    }

    /**
     * (optional)
     * This is a tool-provided value that can be anything, and tools often use it to correlate themselves across deployments. Same as the `tool_id` field within the `extensions` array in the [LTI 1.3 manual configuration](https://developerdocs.instructure.com/services/canvas/external-tools/lti/file.lti_dev_key_config) JSON.
     */
    protected ?string $tool_id = null;
    public function setToolId(string $tool_id)
    {
        $this->tool_id = $tool_id;
        return $this;
    }
    public function getToolId()
    {
        return $this->tool_id;
    }

    /**
     * (optional)
     * This is a tool-provided value that names the tool vendor or developer.
     */
    protected ?string $vendor = null;
    public function setVendor(string $vendor)
    {
        $this->vendor = $vendor;
        return $this;
    }
    public function getVendor()
    {
        return $this->vendor;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        foreach ($data as $propertyName => $value) {
            switch ($propertyName) {
                case self::PRIVACY_LEVEL:
                    $this->setPrivacyLevel($value);
                    break;
                case self::TOOL_ID:
                    $this->setToolId($value);
                    break;
                case self::VENDOR:
                    $this->setVendor($value);
                    break;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            ...parent::jsonSerialize(),
            ...$this->optionalProperties([
                self::PRIVACY_LEVEL => 'privacy_level',
                self::TOOL_ID => 'tool_id',
                self::VENDOR => 'vendor'
            ])
        ];
    }
}
