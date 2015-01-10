<?php
/**
 * Phinx
 *
 * (The MIT license)
 * Copyright (c) 2015 Rob Morgan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated * documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package    Phinx
 * @subpackage Phinx\Db\Adapter
 */
namespace Phinx;

use Phinx\Console\Application;
use Phinx\Wrapper\TextWrapper;

/**
 * Phinx fluent interface.
 *
 * Provides a direct interface for running Phinx commands from code.
 *
 * @author Woody Gilk <woody.gilk@gmail.com>
 */
class Phinx
{
    /**
     * @var TextWrapper
     */
    protected $app;

    /**
     * @var string
     */
    protected $lastOutput;

    /**
     * Create a new instance of Phinx.
     *
     * If no application is provided, the default one will be loaded.
     *
     * @param PhinxApplication $app
     * @param array $options
     */
    public function __construct(PhinxApplication $app = null, array $options = array())
    {
        if (!$app) {
            $app = require __DIR__ . '/../../app/phinx.php';
        }
        $this->app = new TextWrapper($app, $options);
    }

    /**
     * Get the output of the last command run.
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->lastOutput;
    }

    /**
     * Was the last command run successful?
     *
     * @return boolean
     */
    public function wasSuccessful()
    {
        return $this->app->getExitCode() === 0;
    }

    /**
     * Migrate up to the target version.
     *
     * @param  integer $target
     * @return boolean
     */
    public function migrate($target = null)
    {
        $this->lastOutput = $this->app->getMigrate(null, $target);

        return $this->wasSuccessful();
    }

    /**
     * Rollback down to the target version.
     *
     * @param  integer $target
     * @return boolean
     */
    public function rollback($target = null)
    {
        $this->lastOutput = $this->app->getRollback(null, $target);

        return $this->wasSuccessful();
    }
}
