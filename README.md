This package has not been officially released yet. Use at your own risk.

# Installation

This wrapper is PSR-4 autoloading compliant and can be installed via composer. Add the following to your `composer.json`.

    "require": {
	  	"markushausammann/prince-php": "dev-master"
	}

# API documentation

## Set prince path after instance creation

In the official library, the `exePath` is injected into the constructor, but that makes automatic injection of the prince
service harder. Instead use the respective setter.

    $prince = new Prince();
    $prince->setExePath('/usr/local/bin/prince');
    
Please note that the default path is `/usr/local/bin/prince`. So you have the option of just making sure 
the binary of a symlink is in that location if you're running Prince on Linux.

On Windows, be sure to specify the path to the `prince.exe` file located within the `Engine\bin` subfolder of the Prince installation.

## Conversion methods

There are different combination of sources and end products, the (x)html markup can be provided as string or file and
can be returned as file or stream.

*   [`convertFileToFile`](#convertFileToFile)
*   [`convertMultipleFiles`](#convertMultipleFiles)
*   [`convertStringToFile`](#convertStringToFile)
*   [`convertFileToPassthru`](#convertFileToPassthru)
*   [`convertMultipleFilesToPassthru`](#convertMultipleFilesToPassthru)
*   [`convertStringToPassthru`](#convertStringToPassthru)

## Configuration methods

*   [`addStyleSheet`](#addstylesheet)
*   [`clearStyleSheets`](#clearstylesheets)
*   [`addScript`](#addscript)
*   [`clearScripts`](#clearscripts)
*   [`addFileAttachment`](#addfileattachment)
*   [`clearFileAttachments`](#clearfileattachments)
*   [`setLicenseFile`](#setlicensefile)
*   [`setLicenseKey`](#setlicensekey)
*   [`setInputType`](#setinputtype)
*   [`setHTML`](#sethtml)
*   [`setJavaScript`](#setjavascript)
*   [`setLog`](#setlog)
*   [`setBaseURL`](#setbaseurl)
*   [`setXInclude`](#setxinclude)
*   [`setHttpUser`](#sethttpuser)
*   [`setHttpPassword`](#sethttppassword)
*   [`setHttpProxy`](#sethttpproxy)
*   [`setInsecure`](#setinsecure)
*   [`setFileRoot`](#setfileroot)
*   [`setEmbedFonts`](#setembedfonts)
*   [`setSubsetFonts`](#setsubsetfonts)
*   [`setArtificialFonts`](#setartificialfonts)
*   [`setCompress`](#setcompress)
*   [`setPDFTitle`](#setpdftitle)
*   [`setPDFSubject`](#setpdfsubject)
*   [`setPDFAuthor`](#setpdfauthor)
*   [`setPDFKeywords`](#setpdfkeywords)
*   [`setPDFCreator`](#setpdfcreator)
*   [`setEncrypt`](#setencrypt)
*   [`setEncryptInfo`](#setencryptinfo)

</a><a name="convertFileToFile">

    public function convertFileToFile($xmlPath, $pdfPath = '', &$messages = array())

Convert an XML or HTML file to a PDF file. Returns true if a PDF file was generated successfully.

<dl><dt>`xmlPath`</dt><dd>The filename of the input XML or HTML document.</dd><dt>`pdfPath`</dt><dd>The filename of the output PDF file.</dd><dt>`msgs`</dt><dd>An optional array in which to return error and warning messages. Each message is returned as an array of three strings: the message code (`'err'`,`'wrn'` or`'inf'`), the message location (eg. a filename) and the message text.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

</a><a name="convertMultipleFiles">


    public function convertMultipleFiles($xmlPaths, $pdfPath = '', &$messages = array())

Convert multiple XML or HTML files to a PDF file. Returns true if a PDF file was generated successfully.

<dl><dt>`xmlPaths`</dt><dd>An array of the input XML or HTML documents.</dd><dt>`pdfPath`</dt><dd>The filename of the output PDF file.</dd><dt>`msgs`</dt><dd>An optional array in which to return error and warning messages. Each message is returned as an array of three strings: the message code (`'err'`,`'wrn'` or`'inf'`), the message location (eg. a filename) and the message text.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

</a><a name="convertStringToFile">

    public function convertStringToFile($xmlString, $pdfPath = '', &$messages = array())

Convert an XML or HTML string to a PDF file. Returns true if a PDF file was generated successfully.

<dl><dt>`xmlString`</dt><dd>A string containing an XML or HTML document.</dd><dt>`pdfPath`</dt><dd>The filename of the output PDF file.</dd><dt>`msgs`</dt><dd>An optional array in which to return error and warning messages. Each message is returned as an array of three strings: the message code (`'err'`,`'wrn'` or`'inf'`), the message location (eg. a filename) and the message text.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

</a><a name="convertFileToPassthru">

    public function convertFileToPassthru($xmlPath)

Convert an XML or HTML file to a PDF file, which will be passed through to the output buffer of the current PHP page. Returns true if a PDF file was generated successfully.

Currently there is no mechanism to retrieve error/warning messages when using this convert method. However, the`setLog` function can be used to direct messages to an external file.

<dl><dt>`xmlPath`</dt><dd>The filename of the input XML or HTML document.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

Note that to have the browser correctly display the PDF output, the following two lines will be needed before the convert method is called:

    header('Content-Type: application/pdf')
    header('Content-Disposition: inline; filename="foo.pdf"');`

You may also specify `attachment` for the Content-Disposition header instead of `inline`, so that the browser will prompt the user to save the PDF file instead of displaying it.


</a><a name="convertMultipleFilesToPassthru">

    public function convertMultipleFilesToPassthru($xmlPaths)

Convert multiple XML or HTML files to a PDF file, which will be passed through to the output buffer of the current PHP page. Returns true if a PDF file was generated successfully.

Currently there is no mechanism to retrieve error/warning messages when using this convert method. However, the`setLog` function can be used to direct messages to an external file.

<dl><dt>`xmlPaths`</dt><dd>An array of the input XML or HTML documents.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

Note that to have the browser correctly display the PDF output, the following two lines will be needed before the convert method is called:

    header('Content-Type: application/pdf')
    header('Content-Disposition: inline; filename="foo.pdf"');`

You may also specify `attachment` for the Content-Disposition header instead of `inline`, so that the browser will prompt the user to save the PDF file instead of displaying it.


</a><a name="convertStringToPassthru">

    public function convertStringToPassthru($xmlString)

Convert an XML or HTML string to a PDF file, which will be passed through to the output buffer of the current PHP page. Returns true if a PDF file was generated successfully.

Currently there is no mechanism to retrieve error/warning messages when using this convert method. However, the`setLog` function can be used to direct messages to an external file.

<dl><dt>`xmlString`</dt><dd>A string containing an XML or HTML document.</dd><dt>`returns`</dt><dd>True if a PDF file was generated successfully, false otherwise.</dd></dl>

Note that to have the browser correctly display the PDF output, the following two lines will be needed before the convert method is called:

    header('Content-Type: application/pdf')
    header('Content-Disposition: inline; filename="foo.pdf"');`

You may also specify `attachment` for the Content-Disposition header instead of `inline`, so that the browser will prompt the user to save the PDF file instead of displaying it.


</a><a name="addstylesheet">

    public function addStyleSheet($cssPath)

Add a CSS style sheet that will be applied to each input document. The`addStyleSheet` function can be called more than once to add multiple style sheets. This function can called before calling a convert function.

<dl><dt>`cssPath`</dt><dd>The filename of the CSS style sheet to apply.</dd></dl>

</a><a name="clearstylesheets">

    public function clearStyleSheets()

Clear all of the CSS style sheets accumulated by calling`addStyleSheet`.


</a><a name="addscript">

    public function addScript($jsPath)

Add a JavaScript script that will be run before conversion. The`addScript` function can be called more than once to add multiple scripts. This function can be called before calling a convert function.

<dl><dt>`jsPath`</dt><dd>The filename of the script to run.</dd></dl>

</a><a name="clearscripts">

    public function clearScripts()

Clear all of the scripts accumulated by calling`addScript`.


</a><a name="addfileattachment">

    public function addFileAttachment($filePath)

Add a file attachment that will be attached to the PDF file. The`addFileAttachment` can be called more than once to add multiple file attachments.

<dl><dt>`filePath`</dt><dd>The filename of the file attachment.</dd></dl>

</a><a name="clearfileattachments">

    public function clearFileAttachments()

Clear all of the file attachments accumulated by calling`addFileAttachment`.


</a><a name="setlicensefile">

    public function setLicenseFile($file)

Specify the license file.

<dl><dt>`file`</dt><dd>The filename of the license file.</dd></dl>

</a><a name="setlicensekey">

    public function  setLicenseKey($key)

Specify the license key.

<dl><dt>`key`</dt><dd>The license key.</dd></dl>

</a><a name="setinputtype">

    public function setInputType($inputType)

Specify the input type of the document.

<dl><dt>`inputType`</dt><dd>Can take a value of : "xml", "html" or "auto".</dd></dl>

</a><a name="sethtml">

    public function setHTML($html)

Specify whether documents should be parsed as HTML or XML/XHTML.

<dl><dt>`html`</dt><dd>True if all documents should be treated as HTML.</dd></dl>

</a><a name="setjavascript">

    public function setJavaScript($js)

Specify whether JavaScript found in documents should be run.

<dl><dt>`js`</dt><dd>True if document scripts should be run.</dd></dl>

</a><a name="setlog">

    public function setLog($logFile)

Specify a file that Prince should use to log error/warning messages.

<dl><dt>`logFile`</dt><dd>The filename that Prince should use to log error/warning messages, or '' to disable logging.</dd></dl>

</a><a name="setbaseurl">

    public function setBaseURL($baseURL)

Specify the base URL of the input document.

<dl><dt>`baseURL`</dt><dd>The base URL or path of the input document, or ''.</dd></dl>

</a><a name="setxinclude">

    public function setXInclude($xinclude)

Specify whether XML Inclusions (XInclude) processing should be applied to input documents. XInclude processing will be performed by default unless explicitly disabled.

<dl><dt>`xinclude`</dt><dd>False to disable XInclude processing.</dd></dl>

</a><a name="sethttpuser">

    public function setHttpUser($user)

Specify a username to use when fetching remote resources over HTTP.

<dl><dt>`user`</dt><dd>The username to use for basic HTTP authentication.</dd></dl>

</a><a name="sethttppassword">

    public function setHttpPassword($password)

Specify a password to use when fetching remote resources over HTTP.

<dl><dt>`password`</dt><dd>The password to use for basic HTTP authentication.</dd></dl>

</a><a name="sethttpproxy">

    public function setHttpProxy($proxy)

Specify the URL for the HTTP proxy server, if needed.

<dl><dt>`proxy`</dt><dd>The URL for the HTTP proxy server.</dd></dl>

</a><a name="setinsecure">

    public function setInsecure($insecure)

Specify whether to disable SSL verification.

</a><dl><a name="setinsecure"><dt>`insecure`</dt><dd>If set to true, SSL verification is disabled. (not recommended)</dd>

</a><a name="setfileroot">

    public function setFileRoot($fileRoot)

Specify the root directory for absolute filenames. This can be used when converting a local file that uses absolute paths to refer to web resources. For example, /images/logo.jpg can be rewritten to /usr/share/images/logo.jpg by specifying "/usr/share" as the root.

</a><dl><a name="setfileroot"><dt>`fileRoot`</dt><dd>The path to prepend to absolute filenames.</dd>

</a><a name="setembedfonts">

    public function setEmbedFonts($embedFonts)

Specify whether fonts should be embedded in the output PDF file. Fonts will be embedded by default unless explicitly disabled.

<dl><dt>`embedFonts`</dt><dd>False to disable PDF font embedding.</dd></dl>

</a><a name="setsubsetfonts">

    public function setSubsetFonts($subsetFonts)

Specify whether embedded fonts should be subset in the output PDF file. Fonts will be subset by default unless explicitly disabled.

<dl><dt>`subsetFonts`</dt><dd>False to disable PDF font subsetting.</dd></dl>

</a><a name="setartificialfonts">

    public function setArtificialFonts($artificialFonts)

Specify whether artificial bold/italic fonts should be generated if necessary. Artificial fonts are enabled by default.

<dl><dt>`artificialFonts`</dt><dd>False to disable artificial bold/italic fonts.</dd></dl>

</a><a name="setcompress">

    public function setCompress($compress)

Specify whether compression should be applied to the output PDF file. Compression will be applied by default unless explicitly disabled.

<dl><dt>`compress`</dt><dd>False to disable PDF compression.</dd></dl>

</a><a name="setpdftitle">

    public function setPDFTitle($pdfTitle)

Specify the document title for PDF metadata.


</a><a name="setpdfsubject">

    public function setPDFSubject($pdfSubject)

Specify the document subject for PDF metadata.


</a><a name="setpdfauthor">

    public function setPDFAuthor($pdfAuthor)

Specify the document author for PDF metadata.


</a><a name="setpdfkeywords">

    public function setPDFKeywords($pdfKeywords)


Specify the document keywords for PDF metadata.


</a><a name="setpdfcreator">

    public function setPDFCreator($pdfCreator)

Specify the document creator for PDF metadata.


</a><a name="setencrypt">

    public function setEncrypt($encrypt)




Specify whether encryption should be applied to the output PDF file. Encryption will not be applied by default unless explicitly enabled.

<dl><dt>`encrypt`</dt><dd>True to enable PDF encryption.</dd></dl>

</a><a name="setencryptinfo">


    public function setEncryptInfo($keyBits, $userPassword, $ownerPassword,
    $disallowPrint = false, $disallowModify = false, $disallowCopy = false, $disallowAnnotate = false)



Set the parameters used for PDF encryption. Calling this method will also enable encryption, equivalent to calling`setEncrypt(true)`. It should be called before calling a convert method for encryption information to be applied.

<dl><dt>`keyBits`</dt><dd>The size of the encryption key in bits (must be 40 or 128).</dd><dt>`userPassword`</dt><dd>The user password for the PDF file (may be empty).</dd><dt>`ownerPassword`</dt><dd>The owner password for the PDF file (may be empty).</dd><dt>`disallowPrint`</dt><dd>True to disallow printing of the PDF file.</dd><dt>`disallowModify`</dt><dd>True to disallow modification of the PDF file.</dd><dt>`disallowCopy`</dt><dd>True to disallow copying from the PDF file.</dd><dt>`disallowAnnotate`</dt><dd>True to disallow annotation of the PDF file.</dd></dl>

Copyright © 2005-2013 YesLogic Pty. Ltd.

</a></dl></dl>
