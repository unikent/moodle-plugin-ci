<?php

/*
 * This file is part of the Moodle Plugin CI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moodlerooms\MoodlePluginCI\Tests\PluginValidate;

use Moodlerooms\MoodlePluginCI\PluginValidate\Plugin;
use Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\ModuleRequirements;
use Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\RequirementsResolver;

/**
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ModuleRequirementsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleRequirements
     */
    private $requirements;

    protected function setUp()
    {
        $this->requirements = new ModuleRequirements(new Plugin('mod_forum', 'mod', 'forum', ''), 29);
    }

    protected function tearDown()
    {
        $this->requirements = null;
    }

    public function testResolveRequirements()
    {
        $resolver = new RequirementsResolver();

        $this->assertInstanceOf(
            'Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\ModuleRequirements',
            $resolver->resolveRequirements(new Plugin('', 'mod', '', ''), 29)
        );
    }

    public function testGetRequiredFiles()
    {
        $files = $this->requirements->getRequiredFiles();

        $this->assertNotEmpty($files);
        foreach ($files as $file) {
            $this->assertInternalType('string', $file);
        }
    }

    public function testGetRequiredFunctions()
    {
        $functions = $this->requirements->getRequiredFunctions();

        $this->assertNotEmpty($functions);
        foreach ($functions as $function) {
            $this->assertInstanceOf('Moodlerooms\MoodlePluginCI\PluginValidate\Finder\FileTokens', $function);
        }
    }

    public function testGetRequiredStrings()
    {
        $fileToken = $this->requirements->getRequiredStrings();
        $this->assertInstanceOf('Moodlerooms\MoodlePluginCI\PluginValidate\Finder\FileTokens', $fileToken);
        $this->assertEquals('lang/en/forum.php', $fileToken->file);
    }

    public function testGetRequiredCapabilities()
    {
        $fileToken = $this->requirements->getRequiredCapabilities();
        $this->assertInstanceOf('Moodlerooms\MoodlePluginCI\PluginValidate\Finder\FileTokens', $fileToken);
        $this->assertEquals('db/access.php', $fileToken->file);
    }
}
