<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration\Instructure\Canvas;

use GrotonSchool\LTI\Registration\EnumeratedArrayValuesTrait;
use GrotonSchool\LTI\Registration\RegistrationException;
use GrotonSchool\LTI\Registration\v1p0;

class LtiMessage extends v1p0\LtiMessage
{
    use EnumeratedArrayValuesTrait;

    public const DEFAULT_ENABLED = 'https://canvas.instructure.com/lti/course_navigation/default_enabled';
    public const VISIBILITY = 'https://canvas.instructure.com/lti/visibility';
    public const LAUNCH_HEIGHT = 'https://canvas.instructure.com/lti/launch_height';
    public const LAUNCH_WIDTH = 'https://canvas.instructure.com/lti/launch_width';
    public const DISPLAY_TYPE = 'https://canvas.instructure.com/lti/display_type';

    public const VISIBILITY_ADMIN = 'admin';
    public const VISIBILITY_MEMBERS = 'members';
    public const VISIBILITY_PUBLIC = 'public';

    public const VISIBILITY_LEVELS = [
        self::VISIBILITY_ADMIN,
        self::VISIBILITY_MEMBERS,
        self::VISIBILITY_PUBLIC
    ];

    public const DISPLAY_DEFAULT = "default";
    public const DISPLAY_FULL_WIDTH = "full_width";
    public const DISPLAY_FULL_WIDTH_IN_CONTEXT = "full_width_in_context";
    public const DISPLAY_FULL_WIDTH_WITH_NAV = "full_width_with_nav";
    public const DISPLAY_IN_NAV_CONTEXT = "in_nav_context";
    public const DISPLAY_BORDERLESS = "borderless";
    public const DISPLAY_NEW_WINDOW = "new_window";

    public const DISPLAY_TYPES = [
        self::DISPLAY_DEFAULT,
        self::DISPLAY_FULL_WIDTH,
        self::DISPLAY_FULL_WIDTH_IN_CONTEXT,
        self::DISPLAY_FULL_WIDTH_WITH_NAV,
        self::DISPLAY_IN_NAV_CONTEXT,
        self::DISPLAY_BORDERLESS,
        self::DISPLAY_NEW_WINDOW
    ];

    public const PLACEMENT_ACCOUNT_NAVIGATION = 'account_navigation';
    public const PLACEMENT_ASSIGNMENT_EDIT = 'assignment_edit';
    public const PLACEMENT_ASSIGNMENT_GROUP_MENU = 'assignment_group_menu';
    public const PLACEMENT_ASSIGMENT_INDEX_MENU = 'assignment_index_menu';
    public const PLACEMENT_ASSIGNMENT_MENU = 'assignment_menu';
    public const PLACEMENT_ASSIGNMENT_SELECTION = 'assignment_selection';
    public const PLACEMENT_ASSIGNMENT_VIEW = 'assignment_view';
    public const PLACEMENT_COLLABORATION = 'collaboration';
    public const PLACEMENT_COURSE_ASSIGNMENTS_MENU = 'course_assignments_menu';
    public const PLACEMENT_COURSE_HOME_SUB_NAVIGATION = 'course_home_sub_navigation';
    public const PLACEMENT_COURSE_NAVIGATION = 'course_navigation';
    public const PLACEMENT_COURSE_SETTINGS_SUB_NAVIGATION = 'course_settings_sub_navigation';
    public const PLACEMENT_DISCUSSION_INDEX_MENU = 'discussion_topic_index_menu';
    public const PLACEMENT_DISCUSSION_TOPIC_MENU = 'discussion_topic_menu';
    public const PLACEMENT_EDITOR_BUTTON = 'editor_button';
    public const PLACEMENT_FILE_INDEX_MENU = 'file_index_menu';
    public const PLACEMENT_FILE_MENU = 'file_menu';
    public const PLACEMENT_GLOBAL_NAVIGATION = 'global_navigation';
    public const PLACEMENT_HOMEWORK_SUBMISSION = 'homework_submission';
    public const PLACEMENT_LINK_SELECTION = 'link_selection';
    public const PLACEMENT_MIGRATION_SELECTION = 'migration_selection';
    public const PLACEMENT_MODULE_GROUP_MENU = 'module_group_menu';
    public const PLACEMENT_MODULE_INDEX_MENU_MODAL = 'module_index_menu_modal';
    public const PLACEMENT_MODULE_INDEX_MENU_TRAY = 'module_index_menu';
    public const PLACEMENT_MODULE_MENU_MODAL = 'module_menu_modal';
    public const PLACEMENT_MODULE_MENU = 'module_menu';
    public const PLACEMENT_PAGE_INDEX_MENU = 'wiki_index_menu';
    public const PLACEMENT_PAGE_MENU = 'wiki_page_menu';
    public const PLACEMENT_QUIZ_INDEX_MENU = 'quiz_index_menu';
    public const PLACEMENT_QUIZ_MENU = 'quiz_menu';
    public const PLACEMENT_STUDENT_CONTEXT_CARD = 'student_context_card';
    public const PLACEMENT_SUBMISSION_TYPE_SELECTION = 'submission_type_selection';
    public const PLACEMENT_SYNC_GRADES = 'post_grades';
    public const PLACEMENT_TOOL_CONFIGURATION = 'tool_configuration';
    public const PLACEMENT_TOP_NAVIGATION = 'top_navigation';
    public const PLACEMENT_USER_NAVIGATION = 'user_navigation';

    /** @deprecated use assignment_selection and/or link_selection */
    public const PLACEMENT_RESOURCE_SELECTION = 'resource_selection';

    protected const PLACEMENTS_AVAILABLE = [
        self::PLACEMENT_ACCOUNT_NAVIGATION,
        self::PLACEMENT_ASSIGNMENT_EDIT,
        self::PLACEMENT_ASSIGNMENT_GROUP_MENU,
        self::PLACEMENT_ASSIGMENT_INDEX_MENU,
        self::PLACEMENT_ASSIGNMENT_MENU,
        self::PLACEMENT_ASSIGNMENT_SELECTION,
        self::PLACEMENT_ASSIGNMENT_VIEW,
        self::PLACEMENT_COLLABORATION,
        self::PLACEMENT_COURSE_ASSIGNMENTS_MENU,
        self::PLACEMENT_COURSE_HOME_SUB_NAVIGATION,
        self::PLACEMENT_COURSE_NAVIGATION,
        self::PLACEMENT_COURSE_SETTINGS_SUB_NAVIGATION,
        self::PLACEMENT_DISCUSSION_INDEX_MENU,
        self::PLACEMENT_DISCUSSION_TOPIC_MENU,
        self::PLACEMENT_EDITOR_BUTTON,
        self::PLACEMENT_FILE_INDEX_MENU,
        self::PLACEMENT_FILE_MENU,
        self::PLACEMENT_GLOBAL_NAVIGATION,
        self::PLACEMENT_HOMEWORK_SUBMISSION,
        self::PLACEMENT_LINK_SELECTION,
        self::PLACEMENT_MIGRATION_SELECTION,
        self::PLACEMENT_MODULE_GROUP_MENU,
        self::PLACEMENT_MODULE_INDEX_MENU_MODAL,
        self::PLACEMENT_MODULE_INDEX_MENU_TRAY,
        self::PLACEMENT_MODULE_MENU_MODAL,
        self::PLACEMENT_MODULE_MENU,
        self::PLACEMENT_PAGE_INDEX_MENU,
        self::PLACEMENT_PAGE_MENU,
        self::PLACEMENT_QUIZ_INDEX_MENU,
        self::PLACEMENT_QUIZ_MENU,
        self::PLACEMENT_STUDENT_CONTEXT_CARD,
        self::PLACEMENT_SUBMISSION_TYPE_SELECTION,
        self::PLACEMENT_SYNC_GRADES,
        self::PLACEMENT_TOOL_CONFIGURATION,
        self::PLACEMENT_TOP_NAVIGATION,
        self::PLACEMENT_USER_NAVIGATION
    ];

    public function addPlacement(string $placement)
    {
        if (!in_array($placement, self::PLACEMENTS_AVAILABLE)) {
            throw new RegistrationException("'$placement' is not an available placement");
        }
        return parent::addPlacement($placement);
    }

    /**
     * (optional)
     * Only applies if the placement is "course_navigation". If false, the tool will not appear in the course navigation bar, but can still be re-enabled by admins and teachers. Defaults to 'true'. See the "default" setting as discussed in the [Navigation Tools](https://developerdocs.instructure.com/services/canvas/external-tools/lti/placements/file.navigation_tools#settings) docs.
     */
    protected ?bool $default_enabled = null;
    public function setDefaultEnabled(bool $default_enabled)
    {
        $this->default_enabled = $default_enabled;
        return $this;
    }
    public function getDefaultEnabled()
    {
        return $this->default_enabled;
    }

    /**
     * (optional)
     * Determines what users can see a link to launch this message. The "admins" value indicates users that can manage the link can see it, which for the Global Navigation placement means administrators, but in courses means administrators and instructors. The "members" value indicates that any member of the context the link appears in can see the link, and "public" means visible to all.
     * @var string "admins" | "members" | "public"
     */
    protected ?string $visibility = null;
    public function setVisibility(string $visibility)
    {
        $this->validateEnumeratedValues($visibility, self::VISIBILITY_LEVELS);
        $this->visibility = $visibility;
        return $this;
    }
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     *(optional)
     * Specifies the height of the iframe the tool will be embedded in.
     * @var string|int
     */
    protected mixed $launch_height = null;
    public function setLaunchHeight(mixed $launch_height)
    {
        if (is_numeric($launch_height)) {
            $this->launch_height = $launch_height;
            return $this;
        }
        throw new RegistrationException("'$launch_height' is not a valid launch height value");
    }
    public function getLaunchHeight()
    {
        return $this->launch_height;
    }

    /**
     * (optional)
     * Specifies the width of the iframe the tool will be embedded in.
     * @var string|int
     */
    protected mixed $launch_width = null;
    public function setLaunchWidth(mixed $launch_width)
    {
        if (is_numeric($launch_width)) {
            $this->launch_width = $launch_width;
            return $this;
        }
        throw new RegistrationException("'$launch_width' is not a valid launch width value");
    }
    public function getLaunchWidth()
    {
        return $this->launch_width;
    }

    /**
     * (optional)
     * Specifies how to launch the tool. See the [Navigation Tools Settings](https://developerdocs.instructure.com/services/canvas/external-tools/lti/placements/file.navigation_tools#settings) docs for details on each option. Note: "new_window" is only valid for Dynamic Registration, and produces the same behavior as setting `windowTarget: _blank` in a Canvas LTI 1.3 JSON configuration.
     * @var string "default" | "full_width" | "full_width_in_context" | "full_width_with_nav" | "in_nav_context" | "borderless" | "new_window"
     */
    protected ?string $display_type = null;
    public function setDisplayType(string $display_type)
    {
        $this->validateEnumeratedValues($display_type, self::DISPLAY_TYPES);
        $this->display_type = $display_type;
        return $this;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        foreach ($data as $propertyName => $value) {
            switch ($propertyName) {
                case self::DEFAULT_ENABLED:
                    $this->setDefaultEnabled($value);
                    break;
                case self::VISIBILITY:
                    $this->setVisibility($value);
                    break;
                case self::LAUNCH_HEIGHT:
                    $this->setLaunchHeight($value);
                    break;
                case self::LAUNCH_WIDTH:
                    $this->setLaunchWidth($value);
                    break;
                case self::DISPLAY_TYPE:
                    $this->setDisplayType($value);
                    break;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            ...parent::jsonSerialize(),
            ...$this->optionalProperties([
                self::DEFAULT_ENABLED => 'default_enabled',
                self::VISIBILITY => 'visibility',
                self::LAUNCH_HEIGHT => 'launch_height',
                self::LAUNCH_WIDTH => 'launch_width',
                self::DISPLAY_TYPE => 'display_type'
            ])
        ];
    }
}
