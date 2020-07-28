<?php

class DateHelper
{
    /**
     * Get current date
     * @param string $format
     * @return string
     */
    public static function now($format='Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * Format a date
     * @param string $date
     * @param null|string $format
     * @return string
     */
    public static function formatDate($date, $format=null)
    {
        if ($date == null)
            return $date;

        if ($format == null) {
            $format='d-M-Y';
        }

        return date($format, strtotime($date));
    }

    /**
     * Format a Date Time
     * @param string $date
     * @param null|string $format
     * @return string
     */
    public static function formatDateTime($date, $format=null)
    {
        if ($format == null) {
            $format='d-M-Y H:i:s';
        }

        return self::formatDate($date, $format);
    }
}