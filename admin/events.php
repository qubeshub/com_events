<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 HUBzero Foundation, LLC.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @author    Shawn Rice <zooley@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Events\Admin;

if (!\User::authorise('core.manage', 'com_events'))
{
	return \App::abort(404, \Lang::txt('JERROR_ALERTNOAUTHOR'));
}

require_once(dirname(__DIR__) . DS . 'models' . DS . 'tags.php');
require_once(dirname(__DIR__) . DS . 'helpers' . DS . 'date.php');
require_once(dirname(__DIR__) . DS . 'tables' . DS . 'category.php');
require_once(dirname(__DIR__) . DS . 'tables' . DS . 'event.php');
require_once(dirname(__DIR__) . DS . 'tables' . DS . 'config.php');
require_once(dirname(__DIR__) . DS . 'tables' . DS . 'page.php');
require_once(dirname(__DIR__) . DS . 'tables' . DS . 'respondent.php');
require_once(dirname(__DIR__) . DS . 'helpers' . DS . 'html.php');
require_once(dirname(__DIR__) . DS . 'helpers' . DS . 'csv.php');

$controllerName = \Request::getCmd('controller', 'events');
if (!file_exists(__DIR__ . DS . 'controllers' . DS . $controllerName . '.php'))
{
	$controllerName = 'events';
}

\Submenu::addEntry(
	\Lang::txt('COM_EVENTS'),
	\Route::url('index.php?option=com_events&controller=events'),
	$controllerName == 'events'
);
\Submenu::addEntry(
	\Lang::txt('COM_EVENTS_CATEGORIES'),
	\Route::url('index.php?option=com_categories&extension=com_events'),
	$controllerName == 'categories'
);
\Submenu::addEntry(
	\Lang::txt('COM_EVENTS_CONFIGURATION'),
	\Route::url('index.php?option=com_events&controller=configure'),
	$controllerName == 'configure'
);

require_once(__DIR__ . DS . 'controllers' . DS . $controllerName . '.php');
$controllerName = __NAMESPACE__ . '\\Controllers\\' . ucfirst($controllerName);

// Instantiate controller
$controller = new $controllerName();
$controller->execute();
$controller->redirect();
