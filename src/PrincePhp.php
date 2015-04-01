<?php namespace PrincePHP;

use Exception;
use PrincePHP\Exception\InputTypeException;

/**
 * A better PHP wrapper for PrinceXML
 *
 * Improvements in comparison to the original wrapper:
 * - composer installable
 * - PSR-4 compliant
 * - no constructor params so automic injection is possible
 * - complete block documentation
 * - fluent setter interface
 *
 * @todo split into several classes like config, command, metadata, ...
 *
 * Class ServiceWrapper
 * @package PrincePHP
 * @see http://www.princexml.com
 */
class ServiceWrapper
{
    private $exePath = '/usr/local/bin/prince';
    private $styleSheets = '';
    private $scripts = '';
    private $fileAttachments = '';
    private $licenseFile = '';
    private $licenseKey = '';
    private $inputType = 'auto';
    private $javascript = false;
    private $baseURL = '';
    private $doXInclude = true;
    private $httpUser = '';
    private $httpPassword = '';
    private $httpProxy = '';
    private $insecure = false;
    private $logFile = '';
    private $fileRoot = '';
    private $embedFonts = true;
    private $subsetFonts = true;
    private $artificialFonts = true;
    private $compress = true;
    private $pdfTitle = '';
    private $pdfSubject = '';
    private $pdfAuthor = '';
    private $pdfKeywords = '';
    private $pdfCreator = '';
    private $encrypt = false;
    private $encryptInfo = '';
    private $runJavascript = false;

    /**
     * @return string
     */
    public function getExePath()
    {
        return $this->exePath;
    }

    /**
     * @param string $exePath
     * @return ServiceWrapper
     */
    public function setExePath($exePath)
    {
        $this->exePath = $this->addDoubleQuotes(ltrim($exePath));
        return $this;
    }

    /**
     * Style sheet will be applied to each document.
     * Include filename in path.
     *
     * @param string $cssPath
     * @return ServiceWrapper
     */
    public function addStyleSheet($cssPath)
    {
        $this->styleSheets .= '-s "' . $cssPath . '" ';
        return $this;
    }

    /**
     * Clears all CSS stylesheets
     * @return $this
     */
    public function clearStyleSheets()
    {
        $this->styleSheets = '';
        return $this;
    }

    /**
     * Javascript will be run before conversion.
     * Include filename in path.
     *
     * @param string $jsPath
     * @return $this
     */
    public function addScript($jsPath)
    {
        $this->scripts .= '--script "' . $jsPath . '" ';
        return $this;
    }

    /**
     * Clears all JS files
     * @return $this
     */
    public function clearScripts()
    {
        $this->scripts = '';
        return $this;
    }

    /**
     * Adds an attachment to the PDF file.
     * Include filename in path.
     *
     * @param string $filePath
     * @return $this
     */
    public function addFileAttachment($filePath)
    {
        $this->fileAttachments .= '--attach=' . '"' . $filePath . '" ';
        return $this;
    }

    /**
     * Clears all attachment from PDF
     * @return $this
     */
    public function clearFileAttachments()
    {
        $this->fileAttachments = '';
        return $this;
    }

    /**
     * Sets the license file path.
     *
     * @param string $file
     * @return $this
     */
    public function setLicenseFile($file)
    {
        $this->licenseFile = $file;
        return $this;
    }

    /**
     * Sets the license key.
     *
     * @param string $key
     * @return $this
     */
    public function setLicenseKey($key)
    {
        $this->licenseKey = $key;
        return $this;
    }

    /**
     * Lets you specify the source type.
     *
     * @param string $inputType
     * @return $this
     * @throws InputTypeException
     */
    public function setInputType($inputType)
    {
        $allowedTypes = array('xml', 'html', 'auto');

        if (!in_array($inputType, $allowedTypes)) {
            throw new InputTypeException;
        }

        $this->inputType = $inputType;
        return $this;
    }

    /**
     * Specify if Javascript blocks found in the documents should be run.
     * @todo find out why the respective propery didn't exist
     * @param bool $runJavascript
     * @return $this
     */
    public function setJavaScript($runJavascript)
    {
        $this->runJavascript = (bool)$runJavascript;
        return $this;
    }

    /**
     * Specify the location of the prince log file.
     * An empty string disables logging.
     *
     * @param string $logFile
     * @return $this
     */
    public function setLog($logFile)
    {
        $this->logFile = $logFile;
        return $this;
    }

    /**
     * Set the baseUrl or path of the source.
     *
     * @param string $baseURL
     * @return $this
     */
    public function setBaseURL($baseURL)
    {
        $this->baseURL = $baseURL;
        return $this;
    }

    /**
     * Toggle XML Inclusions (XInclude) processing
     *
     * @param bool $xInclude
     * @return $this
     */
    public function toggleXInclude($xInclude = true)
    {
        $this->doXInclude = $xInclude;
        return $this;
    }

    /**
     * Set basic auth user for fetching remote urls
     *
     * @param string $user
     * @return $this
     */
    public function setHttpUser($user)
    {
        $this->httpUser = $this->cmdlineArgEscape($user);
        return $this;
    }

    /**
     * Set basic auth password for fetching remote urls
     *
     * @param string $password
     * @return $this
     */
    public function setHttpPassword($password)
    {
        $this->httpPassword = $this->cmdlineArgEscape($password);
        return $this;
    }

    /**
     * Set a proxy url for remote calls
     *
     * @param string $proxy
     * @return $this
     */
    public function setHttpProxy($proxy)
    {
        $this->httpProxy = $proxy;
        return $this;
    }

    /**
     * Toggle SSL verification
     * Do not switch off for productive use.
     *
     * @param bool $insecure
     * @return $this
     */
    public function setInsecure($insecure)
    {
        $this->insecure = $insecure;
        return $this;
    }

    /**
     * Specify an absolute path as a root to fetch web assets directly.
     * For example, /images/logo.jpg can be rewritten to /usr/share/images/logo.jpg by specifying "/usr/share" as the root.
     *
     * @param string $fileRoot
     * @return $this
     */
    public function setFileRoot($fileRoot)
    {
        $this->fileRoot = $fileRoot;
        return $this;
    }

    /**
     * Toggle PDF font embedding.
     *
     * @param bool $embedFonts
     * @return $this
     */
    public function setEmbedFonts($embedFonts)
    {
        $this->embedFonts = $embedFonts;
        return $this;
    }

    /**
     * Toggle PDF font subsetting.
     *
     * @param bool $subsetFonts
     * @return $this
     */
    public function setSubsetFonts($subsetFonts = true)
    {
        $this->subsetFonts = $subsetFonts;
        return $this;
    }

    /**
     * Toggle artificial font generation.
     *
     * @param bool $artificialFonts
     * @return $this
     */
    public function setArtificialFonts($artificialFonts = true)
    {
        $this->artificialFonts = $artificialFonts;
        return $this;
    }

    /**
     * Toggle compression
     *
     * @param bool $compress
     * @return $this
     */
    public function setCompress($compress = true)
    {
        $this->compress = $compress;
        return $this;
    }

    /**
     * Set document title for PDF metadata.
     *
     * @param string $pdfTitle
     * @return $this
     */
    public function setPDFTitle($pdfTitle)
    {
        $this->pdfTitle = $pdfTitle;
        return $this;
    }

    /**
     * Set document subject for PDF metadata.
     *
     * @param string $pdfSubject
     * @return $this
     */
    public function setPDFSubject($pdfSubject)
    {
        $this->pdfSubject = $pdfSubject;
        return $this;
    }

    /**
     * Set document author for PDF metadata.
     *
     * @param string $pdfAuthor
     * @return $this
     */
    public function setPDFAuthor($pdfAuthor)
    {
        $this->pdfAuthor = $pdfAuthor;
        return $this;
    }

    /**
     * Set the document keywords for PDF metadata.
     *
     * @param string $pdfKeywords
     * @return $this
     */
    public function setPDFKeywords($pdfKeywords)
    {
        $this->pdfKeywords = $pdfKeywords;
        return $this;
    }

    /**
     * Set document creator for PDF metadata.
     *
     * @param string $pdfCreator
     * @return $this
     */
    public function setPDFCreator($pdfCreator)
    {
        $this->pdfCreator = $pdfCreator;
        return $this;
    }

    /**
     * Toggle PDF encryption
     *
     * @param bool $encrypt
     * @return $this
     */
    public function setEncrypt($encrypt)
    {
        $this->encrypt = $encrypt;
        return $this;
    }

    /**
     * Set params for PDF encryption and enable encryption
     *
     * @param $keyBits
     * @param $userPassword
     * @param $ownerPassword
     * @param bool $disallowPrint
     * @param bool $disallowModify
     * @param bool $disallowCopy
     * @param bool $disallowAnnotate
     * @return $this
     * @throws Exception
     */
    public function setEncryptInfo(
        $keyBits,
        $userPassword,
        $ownerPassword,
        $disallowPrint = false,
        $disallowModify = false,
        $disallowCopy = false,
        $disallowAnnotate = false)
    {
        if ($keyBits != 40 && $keyBits != 128) {
            throw new Exception("Invalid value for keyBits: $keyBits" .
                " (must be 40 or 128)");
        }

        $this->encrypt = true;

        $this->encryptInfo =
            ' --key-bits ' . $keyBits .
            ' --user-password="' . $this->cmdlineArgEscape($userPassword) .
            '" --owner-password="' . $this->cmdlineArgEscape($ownerPassword) . '" ';

        if ($disallowPrint) {
            $this->encryptInfo .= '--disallow-print ';
        }

        if ($disallowModify) {
            $this->encryptInfo .= '--disallow-modify ';
        }

        if ($disallowCopy) {
            $this->encryptInfo .= '--disallow-copy ';
        }

        if ($disallowAnnotate) {
            $this->encryptInfo .= '--disallow-annotate ';
        }

        return $this;
    }

    /**
     * Convert source file to PDF file internally.
     *
     * @param string $xmlPath path of the source file
     * @param string $pdfPath optional, where to store the resulting PDF
     * @param array $messages optional array to capture errors/warnings
     * @return bool
     * @throws Exception
     */
    public function convertFileToFile($xmlPath, $pdfPath = '', &$messages = array())
    {
        $pathAndArgs = $this->getCommandLine();

        $pathAndArgs .= '"' . $xmlPath . '"';

        if (strlen(trim($pdfPath)) > 0) {
            $pathAndArgs .= ' -o ' . '"' . $pdfPath . '"';
        }

        return $this->convertInternalFileToFile($pathAndArgs, $messages);
    }

    /**
     * Convert multiple source files to PDF file internally.
     *
     * @param array $xmlPaths paths of the source files
     * @param string $pdfPath optional, where to store the resulting PDF
     * @param array $messages optional array to capture errors/warnings
     * @return bool
     * @throws Exception
     */
    public function convertMultipleFiles($xmlPaths, $pdfPath = '', &$messages = array())
    {
        $pathAndArgs = $this->getCommandLine();

        foreach ($xmlPaths as $xmlPath) {
            $pathAndArgs .= '"' . $xmlPath . '"';
        }

        if (strlen(trim($pdfPath)) > 0) {
            $pathAndArgs .= ' -o ' . '"' . $pdfPath . '"';
        }

        return $this->convertInternalFileToFile($pathAndArgs, $messages);
    }

    /**
     * Convert multiple files and return PDF stream to PHP buffer.
     *
     * @param array $xmlPaths array of source files.
     * @return bool
     * @throws Exception
     */
    public function convertMultipleFilesToPassthru($xmlPaths)
    {
        $pathAndArgs = $this->getCommandLine();
        $pathAndArgs .= '--silent ';

        foreach ($xmlPaths as $xmlPath) {
            $pathAndArgs .= '"' . $xmlPath . '" ';
        }

        $pathAndArgs .= '-o -';

        return $this->convertInternalFileToPassthru($pathAndArgs);
    }

    /**
     * Convert a single file and return PDF stream to PHP buffer
     *
     * @param string $xmlPath
     * @return bool
     * @throws Exception
     */
    public function convertFileToPassthru($xmlPath)
    {
        $pathAndArgs = $this->getCommandLine();
        $pathAndArgs .= '--silent "' . $xmlPath . '" -o -';

        return $this->convertInternalFileToPassthru($pathAndArgs);
    }

    /**
     * Convert markup from a string and return PDF to PHP buffer
     *
     * @param string $xmlString
     * @return bool
     * @throws Exception
     */
    public function convertStringToPassthru($xmlString)
    {
        $pathAndArgs = $this->getCommandLine();
        $pathAndArgs .= '--silent -';

        return $this->convertInternalStringToPassthru($pathAndArgs, $xmlString);
    }

    /**
     * Convert string to PDF file internally.
     *
     * @param string $xmlString source markup
     * @param string $pdfPath optional, where to store the resulting PDF
     * @param array $messages optional array to capture errors/warnings
     * @return bool
     * @throws Exception
     */
    public function convertStringToFile($xmlString, $pdfPath = '', &$messages = array())
    {
        $pathAndArgs = $this->getCommandLine();

        if (strlen(trim($pdfPath)) > 0) {
            $pathAndArgs .= ' - -o "' . $pdfPath . '"';
        }

        return $this->convertInternalStringToFile($pathAndArgs, $xmlString, $messages);
    }

    /**
     * Returns the full prince command to be executed
     *
     * @return string
     */
    private function getCommandLine()
    {
        $cmdline = $this->exePath . ' --server ' . $this->styleSheets . $this->scripts . $this->fileAttachments;

        if (!$this->inputType == "auto") {
            $cmdline .= '-i "' . $this->inputType . '" ';
        }

        if ($this->javascript) {
            $cmdline .= '--javascript ';
        }

        if ($this->baseURL != '') {
            $cmdline .= '--baseurl="' . $this->baseURL . '" ';
        }

        if ($this->doXInclude == false) {
            $cmdline .= '--no-xinclude ';
        }

        if ($this->httpUser != '') {
            $cmdline .= '--http-user="' . $this->httpUser . '" ';
        }

        if ($this->httpPassword != '') {
            $cmdline .= '--http-password="' . $this->httpPassword . '" ';
        }

        if ($this->httpProxy != '') {
            $cmdline .= '--http-proxy="' . $this->httpProxy . '" ';
        }

        if ($this->insecure) {
            $cmdline .= '--insecure ';
        }

        if ($this->logFile != '') {
            $cmdline .= '--log="' . $this->logFile . '" ';
        }

        if ($this->fileRoot != '') {
            $cmdline .= '--fileroot="' . $this->fileRoot . '" ';
        }

        if ($this->licenseFile != '') {
            $cmdline .= '--license-file="' . $this->licenseFile . '" ';
        }

        if ($this->licenseKey != '') {
            $cmdline .= '--license-key="' . $this->licenseKey . '" ';
        }

        if ($this->embedFonts == false) {
            $cmdline .= '--no-embed-fonts ';
        }

        if ($this->subsetFonts == false) {
            $cmdline .= '--no-subset-fonts ';
        }

        if ($this->artificialFonts == false) {
            $cmdline .= '--no-artificial-fonts ';
        }

        if ($this->compress == false) {
            $cmdline .= '--no-compress ';
        }

        if ($this->pdfTitle != '') {
            $cmdline .= '--pdf-title="' . $this->cmdlineArgEscape($this->pdfTitle) . '" ';
        }

        if ($this->pdfSubject != '') {
            $cmdline .= '--pdf-subject="' . $this->cmdlineArgEscape($this->pdfSubject) . '" ';
        }

        if ($this->pdfAuthor != '') {
            $cmdline .= '--pdf-author="' . $this->cmdlineArgEscape($this->pdfAuthor) . '" ';
        }

        if ($this->pdfKeywords != '') {
            $cmdline .= '--pdf-keywords="' . $this->cmdlineArgEscape($this->pdfKeywords) . '" ';
        }

        if ($this->pdfCreator != '') {
            $cmdline .= '--pdf-creator="' . $this->cmdlineArgEscape($this->pdfCreator) . '" ';
        }

        if ($this->encrypt) {
            $cmdline .= '--encrypt ' . $this->encryptInfo;
        }

        return $cmdline;
    }

    /**
     * Execute the prince command to create PDF file from source file
     *
     * @param $pathAndArgs
     * @param $messages
     * @return bool
     * @throws Exception
     */
    private function convertInternalFileToFile($pathAndArgs, &$messages)
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $process = proc_open($pathAndArgs, $descriptorspec, $pipes, NULL, NULL, array('bypass_shell' => TRUE));

        if (is_resource($process)) {
            $result = $this->readMessages($pipes[2], $messages);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);

            return ($result == 'success');
        } else {
            throw new Exception("Failed to execute $pathAndArgs");
        }
    }

    /**
     * Execute the prince command to create PDF file from source string
     *
     * @param $pathAndArgs
     * @param $xmlString
     * @param $messages
     * @return bool
     * @throws Exception
     */
    private function convertInternalStringToFile($pathAndArgs, $xmlString, &$messages)
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $process = proc_open($pathAndArgs, $descriptorspec, $pipes, NULL, NULL, array('bypass_shell' => TRUE));

        if (is_resource($process)) {
            fwrite($pipes[0], $xmlString);
            fclose($pipes[0]);
            fclose($pipes[1]);

            $result = $this->readMessages($pipes[2], $messages);

            fclose($pipes[2]);

            proc_close($process);

            return ($result == 'success');
        } else {
            throw new Exception("Failed to execute $pathAndArgs");
        }
    }

    /**
     * Execute the prince command to return PDF stream from source file
     *
     * @param $pathAndArgs
     * @return bool
     * @throws Exception
     */
    private function convertInternalFileToPassthru($pathAndArgs)
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $process = proc_open($pathAndArgs, $descriptorspec, $pipes, NULL, NULL, array('bypass_shell' => TRUE));

        if (is_resource($process)) {
            fclose($pipes[0]);
            fpassthru($pipes[1]);
            fclose($pipes[1]);

            $result = $this->readMessages($pipes[2], $msgs);

            fclose($pipes[2]);

            proc_close($process);

            return ($result == 'success');
        } else {
            throw new Exception("Failed to execute $pathAndArgs");
        }
    }

    /**
     * Execute the prince command to return PDF stream from source string
     *
     * @param $pathAndArgs
     * @param $xmlString
     * @return bool
     * @throws Exception
     */
    private function convertInternalStringToPassthru($pathAndArgs, $xmlString)
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );

        $process = proc_open($pathAndArgs, $descriptorspec, $pipes, NULL, NULL, array('bypass_shell' => TRUE));

        if (is_resource($process)) {
            fwrite($pipes[0], $xmlString);
            fclose($pipes[0]);
            fpassthru($pipes[1]);
            fclose($pipes[1]);

            $result = $this->readMessages($pipes[2], $msgs);

            fclose($pipes[2]);

            proc_close($process);

            return ($result == 'success');
        } else {
            throw new Exception("Failed to execute $pathAndArgs");
        }
    }

    /**
     * Extract messages
     *
     * @param $pipe
     * @param $messages
     * @return string
     */
    private function readMessages($pipe, &$messages)
    {
        while (!feof($pipe)) {
            $line = fgets($pipe);

            if ($line != false) {
                $messageTag = substr($line, 0, 4);
                $messageBody = rtrim(substr($line, 4));

                if ($messageTag == 'fin|') {
                    return $messageBody;
                } else if ($messageTag == 'msg|') {
                    $message = explode('|', $messageBody, 4);

                    // $msg[0] = 'err' | 'wrn' | 'inf'
                    // $msg[1] = filename / line number
                    // $msg[2] = message text, trailing newline stripped

                    $messages[] = $message;
                } else {
                    // ignore other messages
                }
            }
        }

        return '';
    }

    /**
     * Prepares file paths to be used in command line string.
     *
     * @todo verify if this can be handled more elegantly with native PHP functions
     *
     * @param $string
     * @return string
     */
    private function addDoubleQuotes($string)
    {
        $len = strlen($string);

        $outputStr = '';
        $numWeirdChars = 0;
        $weirdCharsStart = 0;
        $subStrStart = 0;

        for ($i = 0; $i < $len; $i++) {
            if (($string[$i] == ' ') ||
                ($string[$i] == ';') ||
                ($string[$i] == ',') ||
                ($string[$i] == '&') ||
                ($string[$i] == '^') ||
                ($string[$i] == '(') ||
                ($string[$i] == ')')
            ) {
                if ($numWeirdChars == 0) {
                    $outputStr .= substr($string, $subStrStart, ($i - $subStrStart));
                    $weirdCharsStart = $i;
                }
                $numWeirdChars += 1;
            } else {
                if ($numWeirdChars > 0) {
                    $outputStr .= chr(34) . substr($string, $weirdCharsStart, $numWeirdChars) . chr(34);

                    $subStrStart = $i;
                    $numWeirdChars = 0;
                }
            }
        }
        $outputStr .= substr($string, $subStrStart, ($i - $subStrStart));

        return $outputStr;
    }

    /**
     * Wrapper function to merge two types of escaping
     *
     * @param $argStr
     * @return string
     */
    private function cmdlineArgEscape($argStr)
    {
        return $this->cmdlineArgEscape2($this->cmdlineArgEscape1($argStr));
    }

    /**
     * Custom escaping function
     *
     * In the input string $argStr, a double quote with zero or more preceding backslash(es)
     * will be replaced with: n*backslash + doublequote => (2*n+1)*backslash + doublequote
     *
     * @todo verify if this can't be done more elegantly
     *
     * @param $argStr
     * @return string
     */
    private function cmdlineArgEscape1($argStr)
    {
        //chr(34) is character double quote ( " ), chr(92) is character backslash ( \ ).
        $len = strlen($argStr);

        $outputStr = '';
        $subStrStart = 0;

        for ($i = 0; $i < $len; $i++) {
            if ($argStr[$i] == chr(34)) {
                $numSlashes = 0;
                $j = $i - 1;
                while ($j >= 0) {
                    if ($argStr[$j] == chr(92)) {
                        $numSlashes += 1;
                        $j -= 1;
                    } else {
                        break;
                    }
                }

                $outputStr .= substr($argStr, $subStrStart, ($i - $numSlashes - $subStrStart));

                for ($k = 0; $k < $numSlashes; $k++) {
                    $outputStr .= chr(92) . chr(92);
                }
                $outputStr .= chr(92) . chr(34);

                $subStrStart = $i + 1;
            }
        }
        $outputStr .= substr($argStr, $subStrStart, ($i - $subStrStart));

        return $outputStr;
    }

    /**
     * Custom escaping function
     *
     * Double the number of trailing backslash(es):	n*trailing backslash => (2*n)*trailing backslash
     *
     * @todo verify if this can't be done more elegantly
     *
     * @param $argStr
     * @return string
     */
    private function cmdlineArgEscape2($argStr)
    {
        //chr(92) is character backslash ( \ ).
        $len = strlen($argStr);

        $numTrailingSlashes = 0;
        for ($i = ($len - 1); $i >= 0; $i--) {
            if ($argStr[$i] == chr(92)) {
                $numTrailingSlashes += 1;
            } else {
                break;
            }
        }

        while ($numTrailingSlashes > 0) {
            $argStr .= chr(92);
            $numTrailingSlashes -= 1;
        }

        return $argStr;
    }

}
