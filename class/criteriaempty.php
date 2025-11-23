<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmarticle module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

 xoops_load('criteria');

 class CriteriaAllowEmpty extends Criteria{

    public function render(?\XoopsDatabase $db = null)
    {
        $backtick = (false === strpos($this->column, '.')) ? '`' : '';
        $backtick = (false !== strpos($this->column, '(')) ? '' : $backtick;
        $clause = (!empty($this->prefix) ? "{$this->prefix}." : '') . $backtick . $this->column . $backtick;
        if (!empty($this->function)) {
            $clause = sprintf($this->function, $clause);
        }
        if (in_array(strtoupper($this->operator), array('IS NULL', 'IS NOT NULL'))) {
            $clause .= ' ' . $this->operator;
        } else {
            $value = trim((string)$this->value);
            if (!in_array(strtoupper($this->operator), array('IN', 'NOT IN'))) {
                if ((substr($value, 0, 1) !== '`') && (substr($value, -1) !== '`')) {
                    $value = "'{$value}'";
                } elseif (!preg_match('/^[a-zA-Z0-9_\.\-`]*$/', $value)) {
                    $value = '``';
                }
            }
            $clause .= " {$this->operator} {$value}";
        }

        return $clause;
    }
 }