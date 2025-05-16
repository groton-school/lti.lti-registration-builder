<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration\v1p0;

use GrotonSchool\LTI\Registration\PropertyCollectionTrait;
use GrotonSchool\LTI\Registration\UniqueArrayValuesTrait;
use GrotonSchool\LTI\Registration\ValidateUriTrait;
use JsonSerializable;

/**
 * @see https://www.imsglobal.org/spec/lti-dr/v1p0#openid-configuration-0
 */
class OpenIDConfiguration implements JsonSerializable
{
    use PropertyCollectionTrait;
    use UniqueArrayValuesTrait;
    use ValidateUriTrait;

    public const APPLICATION_TYPE = 'application_type';
    public const GRANT_TYPES = 'grant_types';
    public const RESPONSE_TYPES = 'response_types';
    public const REDIRECT_URIS = 'redirect_uris';
    public const INITIATE_LOGIN_URI = 'initiate_login_uri';
    public const CLIENT_NAME = 'client_name';
    public const JWKS_URI = 'jwks_uri';
    public const LOGO_URI = 'logo_uri';
    public const TOKEN_ENDPOINT_AUTH_METHOD = 'token_endpoint_auth_method';
    public const CONTACTS = 'contacts';
    public const CLIENT_URI = 'client_uri';
    public const TOS_URI = 'tos_uri';
    public const POLICY_URI = 'policy_uri';
    public const LTI_TOOL_CONFIGURATION = 'https://purl.imsglobal.org/spec/lti-tool-configuration';
    public const SCOPE = 'scope';

    public const APPLICATION_TYPE_WEB = 'web';

    public const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';
    public const GRANT_TYPE_IMPLICIT = 'implicit';

    public const GRANT_TYPES_REQUIRED = [
        self::GRANT_TYPE_CLIENT_CREDENTIALS,
        self::GRANT_TYPE_IMPLICIT
    ];

    public const RESPONSE_TYPE_ID_TOKEN = 'id_token';

    public const AUTH_METHOD_protected_KEY_JWT = 'protected_key_jwt';

    /**
     * `web`
     */
    protected string $application_type = self::APPLICATION_TYPE_WEB;
    public function getApplicationType()
    {
        return $this->application_type;
    }

    /**
     * Must include `client_credentials` and `implicit`.
     * @var string[]
     */
    protected array $grant_types = self::GRANT_TYPES_REQUIRED;
    /**
     * @param string[] $grant_types
     */
    public function setGrantTypes(array $grant_types)
    {
        foreach (
            [
                ...self::GRANT_TYPES_REQUIRED,
                ...$grant_types
            ] as $grant_type
        ) {
            $this->addGrantType($grant_type);
        }
        return $this;
    }
    public function addGrantType(string $grant_type)
    {
        return $this->addUnique($grant_type, self::GRANT_TYPES);
    }
    public function getGrantTypes()
    {
        return $this->grant_types;
    }

    /**
     * Must include `id_token`. Other values may be included.
     * @var string[]
     */
    protected array $response_types = [self::RESPONSE_TYPE_ID_TOKEN];
    /**
     * @param string[] $response_types
     */
    public function setResponseTypes(array $response_types)
    {
        foreach (
            [
                self::RESPONSE_TYPE_ID_TOKEN,
                ...$response_types
            ] as $response_type
        ) {
            $this->addResponseType($response_type);
        }
        return $this;
    }
    public function addResponseType(string $response_type)
    {
        return $this->addUnique($response_type, self::RESPONSE_TYPES);
    }
    public function getResponseTypes()
    {
        return $this->response_types;
    }

    /**
     * As per OIDCReg specification
     * @var string[]
     */
    protected ?array $redirect_uris = null;
    /**
     * @param string[] $redirect_uris
     */
    public function setRedirectUris(array $redirect_uris)
    {
        foreach ($redirect_uris as $redirect_uri) {
            $this->addRedirectUri($redirect_uri);
        }
        return $this;
    }
    public function addRedirectUri(string $redirect_uri)
    {
        $this->validateUri($redirect_uri);
        return $this->addUnique($redirect_uri, self::REDIRECT_URIS);
    }
    public function getRedirectUris()
    {
        return $this->redirect_uris;
    }

    /**
     * As per OIDCReg specification. URI used by the platform to initiate the LTI launch.
     */
    protected ?string $initiate_login_uri = null;
    public function setInitiateLoginUri(string $initiate_login_uri)
    {
        $this->validateUri($initiate_login_uri);
        $this->initiate_login_uri = $initiate_login_uri;
        return $this;
    }
    public function getInitiateLoginUri()
    {
        return $this->initiate_login_uri;
    }

    /**
     * Name of the Tool to be presented to the End-User. Localized representations may be included as described in Section 2.1 of the [OIDC-Reg](https://www.imsglobal.org/spec/lti-dr/v1p0#bib-oidc-reg) specification.
     */
    protected ?string $client_name = null;
    public function setClientName(string $client_name)
    {
        $this->client_name = $client_name;
        return $this;
    }
    public function getClientName()
    {
        return $this->client_name;
    }

    /**
     * This specification requires the tool to expose its public key using a JSON Web Key Set URI. The value does not need to be specific for this registration i.e. a tool may use the same JSON Web Key Set URI for multiple registrations.
     */
    protected ?string $jwks_uri = null;
    public function setJwksUri(string $jwks_uri)
    {
        $this->validateUri($jwks_uri);
        $this->jwks_uri = $jwks_uri;
        return $this;
    }
    public function getJwksUri()
    {
        return $this->jwks_uri;
    }

    /**
     * (optional)
     * As per OIDCReg specification.
     */
    protected ?string $logo_uri = null;
    public function setLogiUri(string $logo_uri)
    {
        $this->validateUri($logo_uri);
        $this->logo_uri = $logo_uri;
        return $this;
    }
    public function getLogoUri()
    {
        return $this->logo_uri;
    }

    /**
     * `protected_key_jwt`
     */
    protected string $token_endpoint_auth_method = self::AUTH_METHOD_protected_KEY_JWT;
    public function getTokenEndpointAuthMethod()
    {
        return $this->token_endpoint_auth_method;
    }

    // TODO type contacts
    /**
     * (optional)
     * As per OIDCReg specification.
     */
    protected ?array $contacts = null;
    public function setContacts(array $contacts)
    {
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }
        return $this;
    }
    public function addContact(mixed $contact)
    {
        $this->contacts[] = $contact;
        return $this;
    }
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * (optional)
     * As per OIDCReg specification. The platform should present this information to the platform's end users of that tool. Localized representations may be included as described in Section 2.1 of the OIDCReg specification.
     */
    protected ?string $client_uri = null;
    public function setClientUri(string $client_uri)
    {
        $this->validateUri($client_uri);
        $this->client_uri = $client_uri;
        return $this;
    }
    public function getClientUri()
    {
        return $this->client_uri;
    }

    /**
     * (optional)
     * As per OIDCReg specification. The platform should present this information to the platform's end users of that tool. Localized representations may be included as described in Section 2.1 of the OIDCReg specification.
     */
    protected ?string $tos_uri = null;
    public function setTosUri(string $tos_uri)
    {
        $this->validateUri($tos_uri);
        $this->tos_uri = $tos_uri;
        return $this;
    }
    public function getTosUri()
    {
        return $this->tos_uri;
    }

    /**
     * (optional)
     * As per OIDCReg specification. The platform should present this information to the platform's end users of that tool. Localized representations may be included as described in Section 2.1 of the OIDCReg specification.
     */
    protected ?string $policy_uri = null;
    public function setPolicyUri(string $policy_uri)
    {
        $this->validateUri($policy_uri);
        $this->policy_uri = $policy_uri;
        return $this;
    }
    public function getPolicyUri()
    {
        return $this->policy_uri;
    }

    /**
     * A JSON Object object containing LTI specific configuration details for this registration. See below.
     * @see https://www.imsglobal.org/spec/lti-dr/v1p0#lti-configuration-0
     */
    protected ?LtiConfiguration $lti_tool_configuration = null;
    public function setLtiToolConfiguration(LtiConfiguration $lti_tool_configuration)
    {
        $this->lti_tool_configuration = $lti_tool_configuration;
        return $this;
    }
    public function getLtiToolConfiguration()
    {
        return $this->lti_tool_configuration;
    }

    /**
     * As per rfc7591, String containing a space-separated list of scope values the tool requests access to. A tool must require the scopes related to the LTI (and possibly other) services it wishes to be granted access for. A platform should not grant access to services that a tool has not explicitly requested. However a platform administrator may after deployment further restrict access and the tool will need to adapt at runtime if a service access is no more granted.
     */
    protected ?string $scope = null;
    public function setScope(string $scope)
    {
        // TODO validate scope format
        $this->scope = $scope;
        return $this;
    }
    public function addScope(string $scope)
    {
        // TODO validate scope format
        $this->scope = trim("{$this->scope} $scope");
        return $this;
    }
    public function getScope()
    {
        return $this->scope;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $propertyName => $value) {
            switch ($propertyName) {
                case self::GRANT_TYPES:
                    $this->setGrantTypes($value);
                    break;
                case self::RESPONSE_TYPES:
                    $this->setResponseTypes($value);
                    break;
                case self::REDIRECT_URIS:
                    $this->setRedirectUris($value);
                    break;
                case self::INITIATE_LOGIN_URI:
                    $this->setInitiateLoginUri($value);
                    break;
                case self::CLIENT_NAME:
                    $this->setClientName($value);
                    break;
                case self::JWKS_URI:
                    $this->setJwksUri($value);
                    break;
                case self::LOGO_URI:
                    $this->setLogiUri($value);
                    break;
                case self::CONTACTS:
                    $this->setContacts($value);
                    break;
                case self::CLIENT_URI:
                    $this->setClientUri($value);
                    break;
                case self::TOS_URI:
                    $this->setTosUri($value);
                    break;
                case self::POLICY_URI:
                    $this->setPolicyUri($value);
                    break;
                case self::LTI_TOOL_CONFIGURATION:
                    $this->setLtiToolConfiguration($value);
                    break;
                case self::SCOPE:
                    $this->setScope($value);
                    break;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            ...$this->requiredProperties([
                self::APPLICATION_TYPE,
                self::GRANT_TYPES,
                self::RESPONSE_TYPES,
                self::REDIRECT_URIS,
                self::INITIATE_LOGIN_URI,
                self::CLIENT_NAME,
                self::JWKS_URI,
                self::TOKEN_ENDPOINT_AUTH_METHOD,
                self::LTI_TOOL_CONFIGURATION => 'lti_tool_configuration',
                self::SCOPE
            ]),
            ...$this->optionalProperties([
                self::LOGO_URI,
                self::CONTACTS,
                self::CLIENT_URI,
                self::TOS_URI,
                self::POLICY_URI
            ])
        ];
    }
}
