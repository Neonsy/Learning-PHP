<?php

declare(strict_types=1);

namespace MVCSpace\Core\HTTP;

use MVCSpace\Core\Enum\HTTP\ResponseCode;

class Response
{
    /**
     * @var ResponseCode $responseCode The HTTP response code.
     */
    private ResponseCode $responseCode;
    /**
     * @var array $headers The headers that will be sent with the response.
     */
    private array $headers;
    /**
     * @var string $content The content / body to be shown with the response.
     */
    private string $content = '';

    public function __construct()
    {
        /*
         * Every response shall be perceived as failed, until an event calls for modification of that code.
         *
         * For example, when we reach the end of our code, only then it should be set to OK.
         */
        $this->responseCode = ResponseCode::INTERNAL_SERVER_ERROR;

        $this->setDefaultHeaders();
    }

    /**
     * Setting up all the headers, that should be sent by default with every response.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
     * @see https://pentest-tools.com/blog/essential-http-security-headers
     * @see https://www.invicti.com/blog/web-security/http-security-headers/
     * @return void
     */
    private function setDefaultHeaders(): void
    {
        /*
         * Strict-Transport-Security header ensures that the response is only served over a secure connection (HTTPS)
         * The time in seconds indicates, for how long the client should default to accessing the site over HTTPS.
         * Preload indicates, that the site is present on a global list of HTTPS-only sites, allowing for fast loading and mitigating MITM attacks.
         * This does not have any effect in this case, because this is a demo project without HTTPS
         */
        $this->addHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        /*
         * Content-Security-Policy header is used to control the resources (such as scripts, images, fonts, etc.) that a web page can load.
         * I'm going to allow from all origins, but that is not recommended for production.
         */
        $this->addHeader('Content-Security-Policy', "default-src *; script-src * 'unsafe-inline'; font-src *; style-src *");
        /*
         * X-Frame-Options header is used to prevent the website from being embedded in an iframe.
         * In the case of "SAMEORIGIN", it allows the website to be embedded in an iframe if that website is the same as the website you want to frame.
         */
        $this->addHeader('X-Frame-Options', 'SAMEORIGIN');
        /*
         * X-XSS-Protection header is used to enable the cross-site scripting (XSS) protection in most modern web browsers.
         * Value "1" means XSS protection is enabled and the browser will block the page from loading when a XSS attack is detected.
         * "mode=block" means the browser will completely block the page from loading instead of sanitizing the content.
         */
        $this->addHeader('X-XSS-Protection', '1; mode=block');
        /*
         * The X-Content-Type-Options header with the value "nosniff" ensures that the client does not attempt to guess the format of the data being received.
         * This helps to prevent attacks, where the client is being tricked to think that for example a javascript file is an image.
         */
        $this->addHeader('X-Content-Type-Options', 'nosniff');
        /*
         * Referrer-Policy header is used to control how much referrer information should be sent to other sites when a user clicks a link.
         * "strict-origin-when-cross-origin" means that the referrer will only be sent to the same origin / site.
         * When going to a different origin / site, only the origin / base url will be sent (no path information).
         * So this setting preserves most of the referrer's usefulness, while mitigating the risk of leaking data cross-origins.
         */
        $this->addHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        /*
         * X-Powered-By header is used to identify the technology used to build the website.
         * In this case I just overwrote the default value with the name of the framework.
         */
        $this->addHeader('X-Powered-By', 'MVCSpace Framework');
    }

    /**
     * Adds a header to be later sent with the full response.
     * @param string $header
     * @param string $value
     * @return $this For chaining.
     * @see self::send()
     */
    public function addHeader(string $header, string $value): self
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * Specifies the content to be shown with the response.
     * @param string $content
     * @return $this For chaining.
     */
    public function specifyContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Specifies the responseCode to be sent with the response.
     * @param ResponseCode $code
     * @return $this For chaining.
     */
    public function responseCode(ResponseCode $code): self
    {
        $this->responseCode = $code;
        return $this;
    }

    /**
     * Redirects the client to the provided path.
     * @param string $path
     * @param bool $isHTMX When working with HTMX, which will be used later, we need a different header.
     * @return never
     * @see https://htmx.org/reference/#response_headers
     */
    public function redirect(string $path, bool $isHTMX = false): never
    {
        $this->responseCode = ResponseCode::REDIRECT;

        if (!$isHTMX) { // To make it work with alert script
            header("Location: $path", true, $this->responseCode->value);
        } else {
            header("HX-Redirect: $path", true, $this->responseCode->value);
        }
        exit;
    }

    /**
     * Builds and serves the HTTP response.
     * @return never Exits the application after, because this should be the final thing to do.
     */
    public function send(): never
    {
        // 1. Remove all previously set headers
        header_remove();

        // 2. Set all class stored headers
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }

        // 3. Set the status code
        http_response_code($this->responseCode->value);

        // 4. Output the body / content
        echo $this->content;

        // 5. Stop the application, because everything is done
        exit;
    }
}