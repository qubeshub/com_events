<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2011 Purdue University. All rights reserved.
 *
 * This file is part of: The HUBzero(R) Platform for Scientific Collaboration
 *
 * The HUBzero(R) Platform for Scientific Collaboration (HUBzero) is free
 * software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * HUBzero is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @copyright Copyright 2005-2011 Purdue University. All rights reserved.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

Toolbar::title( Lang::txt( 'COM_EVENTS_MANAGER' ) . ': ' . Lang::txt( 'COM_EVENTS_CONFIGURATION' ), 'event.png' );
Toolbar::save();
Toolbar::cancel();
?>

<form action="<?php echo Route::url('index.php?option=' . $this->option); ?>" method="post" name="adminForm">
	<fieldset class="adminform">
		<legend><span><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG'); ?></span></legend>

		<table class="admintable">
			<tbody>
				<tr>
					<td class="key" style="width:265px;"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_ADMINMAIL'); ?></td>
					<td><input type="text" name="config[adminmail]" size="30" maxlength="50" value="<?php echo $this->config->adminmail; ?>" /></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_ADMINLEVEL'); ?></td>
					<td><?php
					$level[] = Html::select('option', '0', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_ALL'), 'value', 'text' );
					$level[] = Html::select('option', '1', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_SPECIAL'), 'value', 'text' );
					echo Html::select('genericlist', $level, 'config[adminlevel]', '', 'value', 'text', $this->config->adminlevel, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_FIRSTDAY'); ?></td>
					<td><?php
					$first[] = Html::select('option', '0', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_SUNDAY_FIRST'), 'value', 'text' );
					$first[] = Html::select('option', '1', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_MONDAY_FIRST'), 'value', 'text' );
					echo Html::select('genericlist', $first, 'config[starday]', '', 'value', 'text', $this->config->starday, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_VIEWMAIL'); ?></td>
					<td><?php
					$viewm[] = Html::select('option', 'YES', Lang::txt('JYES'), 'value', 'text' );
					$viewm[] = Html::select('option', 'NO', Lang::txt('JNO'), 'value', 'text' );
					echo Html::select('genericlist', $viewm, 'config[mailview]', '', 'value', 'text', $this->config->mailview, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_VIEWBY'); ?></td>
					<td><?php
					$viewb[] = Html::select('option', 'YES', Lang::txt('YES'), 'value', 'text' );
					$viewb[] = Html::select('option', 'NO', Lang::txt('JNO'), 'value', 'text' );
					echo Html::select('genericlist', $viewb, 'config[byview]', '', 'value', 'text', $this->config->byview, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_VIEWHITS'); ?></td>
					<td><?php
					$viewh[] = Html::select('option', 'YES', Lang::txt('YES'), 'value', 'text' );
					$viewh[] = Html::select('option', 'NO', Lang::txt('JNO'), 'value', 'text' );
					echo Html::select('genericlist', $viewh, 'config[hitsview]', '', 'value', 'text', $this->config->hitsview, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_DATEFORMAT'); ?></td>
					<td><?php
					$datef[] = Html::select('option', '0', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_FRENCH_ENGLISH'), 'value', 'text' );
					$datef[] = Html::select('option', '1', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_US'), 'value', 'text' );
					$datef[] = Html::select('option', '2', Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_DEUTSCH'), 'value', 'text' );
					echo Html::select('genericlist', $datef, 'config[dateformat]', '', 'value', 'text', $this->config->dateformat, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_TIMEFORMAT'); ?></td>
					<td><?php
					$stdTime[] = Html::select('option', 'YES', Lang::txt('YES'), 'value', 'text' );
					$stdTime[] = Html::select('option', 'NO', Lang::txt('JNO'), 'value', 'text' );
					echo Html::select('genericlist', $stdTime, 'config[calUseStdTime]', '', 'value', 'text', $this->config->calUseStdTime, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_STARTPAGE'); ?></td>
					<td><?php
					$startpg[] = Html::select('option', 'day', Lang::txt('COM_EVENTS_CAL_LANG_REP_DAY'), 'value', 'text' );
					$startpg[] = Html::select('option', 'week', Lang::txt('COM_EVENTS_CAL_LANG_REP_WEEK'), 'value', 'text' );
					$startpg[] = Html::select('option', 'month', Lang::txt('COM_EVENTS_CAL_LANG_REP_MONTH'), 'value', 'text' );
					$startpg[] = Html::select('option', 'year', Lang::txt('COM_EVENTS_CAL_LANG_REP_YEAR'), 'value', 'text' );
					$startpg[] = Html::select('option', 'categories', Lang::txt('COM_EVENTS_CAL_LANG_EVENT_CATEGORIES'), 'value', 'text' );
					echo Html::select('genericlist', $startpg, 'config[startview]', '', 'value', 'text', $this->config->startview, false, false );
					?></td>
				</tr>
				<tr>
					<td class="key"><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CONFIG_NUMEVENTS'); ?></td>
					<td><input type="text" size="3" name="config[calEventListRowsPpg]" value="<?php echo $this->config->calEventListRowsPpg; ?>" /></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<fieldset class="adminform">
		<legend><span><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CUSTOM_FIELDS'); ?></span></legend>

		<table class="admintable">
			<thead>
				<tr>
					<th><?php echo Lang::txt('COM_EVENTS_CAL_LANG_FIELD'); ?></th>
					<th><?php echo Lang::txt('COM_EVENTS_CAL_LANG_TYPE'); ?></th>
					<th><?php echo Lang::txt('COM_EVENTS_CAL_LANG_REQUIRED'); ?></th>
					<th><?php echo Lang::txt('COM_EVENTS_CAL_LANG_SHOW'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$fields = $this->config->fields;
			$r = count($fields);
			if ($r > 10) {
				$n = $r;
			} else {
				$n = 10;
			}
			for ($i=0; $i < $n; $i++)
			{
				if ($r == 0 || !isset($fields[$i])) {
					$fields[$i] = array();
					$fields[$i][0] = NULL;
					$fields[$i][1] = NULL;
					$fields[$i][2] = NULL;
					$fields[$i][3] = NULL;
					$fields[$i][4] = NULL;
				}
				?>
				<tr>
					<td><input type="text" name="fields[<?php echo $i; ?>][title]" value="<?php echo $fields[$i][1]; ?>" maxlength="255" /></td>
					<td><select name="fields[<?php echo $i; ?>][type]">
						<option value="text"<?php echo ($fields[$i][2]=='text') ? ' selected="selected"':''; ?>><?php echo Lang::txt('COM_EVENTS_CAL_LANG_TEXT'); ?></option>
						<option value="checkbox"<?php echo ($fields[$i][2]=='checkbox') ? ' selected="selected"':''; ?>><?php echo Lang::txt('COM_EVENTS_CAL_LANG_CHECKBOX'); ?></option>
					</select></td>
					<td><input type="checkbox" name="fields[<?php echo $i; ?>][required]" value="1"<?php echo ($fields[$i][3]) ? ' checked="checked"':''; ?> /></td>
					<td><input type="checkbox" name="fields[<?php echo $i; ?>][show]" value="1"<?php echo ($fields[$i][4]) ? ' checked="checked"':''; ?> /></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</fieldset>

	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
	<input type="hidden" name="controller" value="<?php echo $this->controller; ?>" />

	<?php echo Html::input('token'); ?>
</form>
