<?php

namespace XoopsModules\Wgsimpleacc;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  wgsimpleacc
 *
 * @package      \module\wgsimpleacc\class
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <owners@zyspec.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since        
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\{Helper, Constants, Form\FormInline};

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    /**
     * @public function to convert float into string
     * @return string
     */
    public static function CustomDateFormat() {

        // $customDateFormat: fix problem that XoopsFormTextDateSelect use _SHORTDATESTRING and _DATESTRING can differ
        // e.g. english:
        // \define('_DATESTRING',      'Y/n/j G:i:s');
        // \define('_SHORTDATESTRING', 'm/d/Y');
        return _SHORTDATESTRING . ' H:i';

    }

    /**
     * @public function to get text of transaction status
     * @param $status
     * @return string
     */
    public static function getTraStatusText($status)
    {
        switch ($status) {
            case Constants::TRASTATUS_NONE:
            default:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_NONE;
                break;
            case Constants::TRASTATUS_DELETED:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_DELETED;
                break;
            case Constants::TRASTATUS_CREATED:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_CREATED;
                break;
            case Constants::TRASTATUS_SUBMITTED:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_SUBMITTED;
                break;
            case Constants::TRASTATUS_APPROVED:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_APPROVED;
                break;
            case Constants::TRASTATUS_LOCKED:
                $status_text = \_MA_WGSIMPLEACC_TRASTATUS_LOCKED;
                break;
        }

        return $status_text;
    }
    /**
     * @public function to get text of balance status
     * @param $status
     * @return string
     */
    public static function getBalStatusText($status)
    {
        switch ($status) {
            case Constants::BALSTATUS_NONE:
            default:
                $status_text = \_MA_WGSIMPLEACC_BALSTATUS_NONE;
                break;
            case Constants::BALSTATUS_APPROVED:
                $status_text = \_MA_WGSIMPLEACC_BALSTATUS_APPROVED;
                break;
            case Constants::BALSTATUS_TEMPORARY:
                $status_text = \_MA_WGSIMPLEACC_BALSTATUS_TEMPORARY;
                break;
        }

        return $status_text;
    }

    /**
     * @public function to get colors for charts
     * @return array
     */
    public static function getColors()
    {
        $colors = [];
        $colors[] = ['name' => 'lightred',    'code' => '#ff9999', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTRED];
        $colors[] = ['name' => 'red',         'code' => '#ff3333', 'descr' => \_MA_WGSIMPLEACC_COLOR_RED];
        $colors[] = ['name' => 'darkred',     'code' => '#990000', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKRED];
        $colors[] = ['name' => 'lightorange', 'code' => '#ffcc99', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTORANGE];
        $colors[] = ['name' => 'orange',      'code' => '#ff9933', 'descr' => \_MA_WGSIMPLEACC_COLOR_ORANGE];
        $colors[] = ['name' => 'darkorange',  'code' => '#993300', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKORANGE];
        $colors[] = ['name' => 'lightyellow', 'code' => '#ffffcc', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTYELLOW];
        $colors[] = ['name' => 'yellow',      'code' => '#ffff66', 'descr' => \_MA_WGSIMPLEACC_COLOR_YELLOW];
        $colors[] = ['name' => 'darkyellow',  'code' => '#999900', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKYELLOW];
        $colors[] = ['name' => 'lightgreen',  'code' => '#ccff99', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTGREEN];
        $colors[] = ['name' => 'green',       'code' => '#66cc00', 'descr' => \_MA_WGSIMPLEACC_COLOR_GREEN];
        $colors[] = ['name' => 'darkgreen',   'code' => '#339900', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKGREEN];
        $colors[] = ['name' => 'lightblue',   'code' => '#99ccff', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTBLUE];
        $colors[] = ['name' => 'blue',        'code' => '#3399ff', 'descr' => \_MA_WGSIMPLEACC_COLOR_BLUE];
        $colors[] = ['name' => 'darkblue',    'code' => '#0066cc', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKBLUE];
        $colors[] = ['name' => 'purple',      'code' => '#9966cc', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTPURPLE];
        $colors[] = ['name' => 'lightpurple', 'code' => '#cc99ff', 'descr' => \_MA_WGSIMPLEACC_COLOR_PURPLE];
        $colors[] = ['name' => 'darkpurple',  'code' => '#660099', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKPURPLE];
        $colors[] = ['name' => 'lightbrown',  'code' => '#996666', 'descr' => \_MA_WGSIMPLEACC_COLOR_LIGHTBROWN];
        $colors[] = ['name' => 'brown',       'code' => '#663300', 'descr' => \_MA_WGSIMPLEACC_COLOR_BROWN];
        $colors[] = ['name' => 'darkbrown',   'code' => '#330000', 'descr' => \_MA_WGSIMPLEACC_COLOR_DARKBROWN];
        $colors[] = ['name' => 'grey',        'code' => '#999999', 'descr' => \_MA_WGSIMPLEACC_COLOR_GREY];

        return $colors;
    }

    /**
     * @public function to get colors for charts
     * @param $colorArray
     * @param $colorSearch
     * @return string|bool
     */
    public static function getColorName($colorArray, $colorSearch)
    {
        foreach ($colorArray as $color) {
            if ($color['code'] == $colorSearch) {
                return $color['name'];
            }
        }

        return false;
    }

    /**
     * @public function to get form for filter period
     * @param int $filterFrom
     * @param int $filterTo
     * @param string $op
     * @return \XoopsForm FormInline
     */
    public static function getFormFilterPeriod($filterFrom, $filterTo, $op = 'list')
    {

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new FormInline('', 'formFilter', $_SERVER['REQUEST_URI'], 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgsa-form-inline"');
        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        //Form  Tray with select date from/to
        $selectFromToTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_FILTERBY_PERIOD . ': ', '&nbsp;');
        $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_FILTER_PERIODFROM, 'filterFrom', '', $filterFrom));
        $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_FILTER_PERIODTO, 'filterTo', '', $filterTo));
        $form->addElement($selectFromToTray);
        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        //button
        $btnApply = new \XoopsFormButton('', 'submit', \_MA_WGSIMPLEACC_FILTER_APPLY, 'submit');
        $form->addElement($btnApply);
        $form->addElement(new \XoopsFormHidden('op', $op));

        return $form;
    }

    /**
     * @public function to convert float into string
     * @param  float $float
     * @return string
     */
    public static function FloatToString($float) {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (empty($float)) {
            $float = 0;
        }
        $dec = $helper->getConfig('sep_comma');
        $thnd = $helper->getConfig('sep_thousand');
        return \number_format($float, 2, $dec, $thnd);

    }

    /**
     * @public function to convert string into float
     * @param  string $str
     * @return float
     */
    public static function StringToFloat($str) {

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $dec = $helper->getConfig('sep_comma');
        $thnd = $helper->getConfig('sep_thousand');

        $str = \preg_replace('[^0-9\,\.\-\+]', '', (string)$str);
        $str = \str_replace($thnd, '', $str);
        $str = \str_replace(' ', '', $str);
        $str = \str_replace($dec, '.', $str);

        return (float)$str;

    }

    /**
     * @public function to convert mimetypes into extensions
     * @param  string $mime
     * @return string
     */
    public static function MimetypeToExtension($mime) {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'image/jpe'                                                                 => 'jpe',
            'image/jpg'                                                                 => 'jpg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'audio/mp4'                                                                 => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'font/otf'                                                                  => 'otf',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'font/ttf'                                                                  => 'ttf',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'image/webp'                                                                => 'webp',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'font/woff'                                                                 => 'woff',
            'font/woff2'                                                                => 'woff2',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
        ];

        return $mime_map[$mime] ?? $mime;
    }

    /**
     * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
     * www.gsdesign.ro/blog/cut-html-string-without-breaking-the-tags
     * www.cakephp.org
     *
     * @param string $text         String to truncate.
     * @param int    $length       Length of returned string, including ellipsis.
     * @param string $ending       Ending to be appended to the trimmed string.
     * @param bool   $exact        If false, $text will not be cut mid-word
     * @param bool   $considerHtml If true, HTML tags would be handled correctly
     *
     * @return string Trimmed string.
     */
    public static function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true)
    {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (mb_strlen(\preg_replace('/<.*?' . '>/', '', $text)) <= $length) {
                return $text;
            }
            // splits all html-tags to scanable lines
            \preg_match_all('/(<.+?' . '>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = mb_strlen($ending);
            $open_tags    = [];
            $truncate     = '';
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash
                    if (\preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                        // if tag is a closing tag
                    } elseif (\preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = \array_search($tag_matchings[1], $open_tags, true);
                        if (false !== $pos) {
                            unset($open_tags[$pos]);
                        }
                        // if tag is an opening tag
                    } elseif (\preg_match('/^<\s*([^\s>!]+).*?' . '>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        \array_unshift($open_tags, \mb_strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = mb_strlen(\preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length + $content_length > $length) {
                    // the number of characters which are left
                    $left            = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (\preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($left >= $entity[1] + 1 - $entities_length) {
                                $left--;
                                $entities_length += mb_strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= mb_substr($line_matchings[2], 0, $left + $entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                }
                $truncate     .= $line_matchings[2];
                $total_length += $content_length;

                // if the maximum length is reached, get off the loop
                if ($total_length >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            }
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = \mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        // add the defined ending to the text
        if (\strlen($truncate) > 0) {
            $truncate .= $ending;
        }
        if ($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }

    /**
     * @param \Xmf\Module\Helper $helper
     * @param array|null         $options
     * @return \XoopsFormDhtmlTextArea|\XoopsFormEditor
     */
    public static function getEditor($helper = null, $options = null)
    {
        /** @var Wgsimpleacc\Helper $helper */
        if (null === $options) {
            $options           = [];
            $options['name']   = 'Editor';
            $options['value']  = 'Editor';
            $options['rows']   = 10;
            $options['cols']   = '100%';
            $options['width']  = '100%';
            $options['height'] = '400px';
        }

        $isAdmin = $helper->isUserAdmin();

        if (\class_exists('XoopsFormEditor')) {
            if ($isAdmin) {
                $descEditor = new \XoopsFormEditor(\ucfirst($options['name']), $helper->getConfig('editorAdmin'), $options, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\ucfirst($options['name']), $helper->getConfig('editorUser'), $options, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\ucfirst($options['name']), $options['name'], $options['value'], '100%', '100%');
        }

        //        $form->addElement($descEditor);

        return $descEditor;
    }

    //--------------- Custom module methods -----------------------------

    /**
     * @param $about
     * @return string
     */
    public static function makeDonationForm($about)
    {
        $donationform = [
            0   => '<form name="donation" id="donation" action="http://www.txmodxoops.org/modules/xdonations/" method="post" onsubmit="return xoopsFormValidate_donation();">',
            1   => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'
                   . \_AM_WGSIMPLEACC_ABOUT_MAKE_DONATION
                   . '</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">'
                   . \_AM_WGSIMPLEACC_DONATION_AMOUNT
                   . '</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 EUR</option><option value="10">10.00 EUR</option><option value="20">20.00 EUR</option><option value="40">40.00 EUR</option><option value="60">60.00 EUR</option><option value="80">80.00 EUR</option><option value="90">90.00 EUR</option><option value="100">100.00 EUR</option><option value="200">200.00 EUR</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'
                   . _SUBMIT
                   . '" title="'
                   . _SUBMIT
                   . '" type="submit"></td></tr></tbody></table>',
            2   => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="EUR" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.txmodxoops.org/modules/xdonations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.txmodxoops.org/modules/xdonations/success.php" type="hidden"></form>',
            'D' => '',
            3   => '',
            4   => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected === true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->',
        ];
        $paypalform   = [
            0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
            1 => '<input name="cmd" value="_s-xclick" type="hidden">',
            2 => '<input name="hosted_button_id" value="%s" type="hidden">',
            3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
            4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
            5 => '</form>',
        ];
        for ($key = 0; $key <= 4; ++$key) {
            if ($key == 2) {
                $donationform[$key] = \sprintf(
                    $donationform[$key],
                    $GLOBALS['xoopsConfig']['sitename'] . ' - ' . ('' != $GLOBALS['xoopsUser']->getVar('name') ? $GLOBALS['xoopsUser']->getVar('name') . ' [' . $GLOBALS['xoopsUser']->getVar('uname') . ']' : $GLOBALS['xoopsUser']->getVar('uname')),
                    $GLOBALS['xoopsUser']->getVar('email'),
                    XOOPS_LICENSE_KEY,
                    \mb_strtoupper($GLOBALS['xoopsModule']->getVar('dirname')),
                    \mb_strtoupper($GLOBALS['xoopsModule']->getVar('dirname')) . ' ' . $GLOBALS['xoopsModule']->getVar('name')
                );
            }
        }
        $aboutRes = '';
        $istart   = mb_strpos($about, $paypalform[0], 1);
        $iend     = mb_strpos($about, $paypalform[5], $istart + 1) + mb_strlen($paypalform[5]) - 1;
        $aboutRes .= mb_substr($about, 0, $istart - 1);
        $aboutRes .= \implode("\n", $donationform);
        $aboutRes .= mb_substr($about, $iend + 1, mb_strlen($about) - $iend - 1);

        return $aboutRes;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public static function UcFirstAndToLower($str)
    {
        return \ucfirst(\mb_strtolower(\trim($str)));
    }

    /** function to replace html-tags by blank space
     * cleaned text is for use in dropdowns
     * @param $string
     *
     * @return string
     */
    public static function cleanTextDropdown($string) {

        if (empty($string)) {
            return '';
        }
        // ----- remove HTML TAGs -----
        $string = preg_replace ('/<[^>]*>/', ' ', $string);

        // ----- remove control characters -----
        $string = str_replace("\r", '', $string);    // --- replace with empty space
        $string = str_replace("\n", ' ', $string);   // --- replace with space
        $string = str_replace("\t", ' ', $string);   // --- replace with space

        // ----- remove multiple spaces -----
        return trim(preg_replace('/ {2,}/', ' ', $string));

    }
}
