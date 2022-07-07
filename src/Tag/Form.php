<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/forms.html#the-form-element
 */
final class Form extends NormalTag
{
    use TagContentTrait;

    public const ENCTYPE_APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    public const ENCTYPE_MULTIPART_FORM_DATA = 'multipart/form-data';
    public const ENCTYPE_TEXT_PLAIN = 'text/plain';

    private ?string $csrfToken = null;
    private ?string $csrfName = null;

    public function get(?string $url = null): self
    {
        $new = clone $this;
        $new->attributes['method'] = 'GET';
        if ($url !== null) {
            $new->attributes['action'] = $url;
        }
        return $new;
    }

    public function post(?string $url = null): self
    {
        $new = clone $this;
        $new->attributes['method'] = 'POST';
        if ($url !== null) {
            $new->attributes['action'] = $url;
        }
        return $new;
    }

    /**
     * @param string|Stringable|null $token
     */
    public function csrf($token, string $name = '_csrf'): self
    {
        $new = clone $this;
        $new->csrfToken = $token === null ? null : (string)$token;
        $new->csrfName = $name;
        return $new;
    }

    /**
     * Character encodings to use for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/forms.html#attr-form-accept-charset
     */
    public function acceptCharset(?string $charset): self
    {
        $new = clone $this;
        $new->attributes['accept-charset'] = $charset;
        return $new;
    }

    /**
     * The URL to use for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-action
     */
    public function action(?string $url): self
    {
        $new = clone $this;
        $new->attributes['action'] = $url;
        return $new;
    }

    /**
     * Default setting for autofill feature for controls in the form.
     *
     * @link https://html.spec.whatwg.org/multipage/forms.html#attr-form-autocomplete
     */
    public function autocomplete(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['autocomplete'] = $value ? 'on' : 'off';
        return $new;
    }

    /**
     * Entry list encoding type to use for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-enctype
     */
    public function enctype(?string $enctype): self
    {
        $new = clone $this;
        $new->attributes['enctype'] = $enctype;
        return $new;
    }

    /**
     * All characters are encoded before sending.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm:attr-fs-enctype-urlencoded
     */
    public function enctypeApplicationXWwwFormUrlencoded(): self
    {
        return $this->enctype(self::ENCTYPE_APPLICATION_X_WWW_FORM_URLENCODED);
    }

    /**
     * The type that allows file `<input>` element(s) to upload file data.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm:attr-fs-enctype-formdata
     */
    public function enctypeMultipartFormData(): self
    {
        return $this->enctype(self::ENCTYPE_MULTIPART_FORM_DATA);
    }

    /**
     * Sends data without any encoding at all. Not recommended.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#form-submission-algorithm:attr-fs-enctype-text
     */
    public function enctypeTextPlain(): self
    {
        return $this->enctype(self::ENCTYPE_TEXT_PLAIN);
    }

    /**
     * The method content attribute specifies how the form-data should be submitted.
     *
     * @param string $method The method attribute value.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-method
     */
    public function method(?string $method): self
    {
        $new = clone $this;
        $new->attributes['method'] = $method;
        return $new;
    }

    /**
     * A boolean attribute, which, if present, indicate that the form is not to be validated during submission.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-novalidate
     */
    public function noValidate(bool $noValidate = true): self
    {
        $new = clone $this;
        $new->attributes['novalidate'] = $noValidate;
        return $new;
    }

    /**
     * Browsing context for form submission.
     *
     * @param string|null $target The target attribute value.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fs-target
     * @link https://html.spec.whatwg.org/multipage/browsers.html#valid-browsing-context-name-or-keyword
     */
    public function target(?string $target): self
    {
        $new = clone $this;
        $new->attributes['target'] = $target;
        return $new;
    }

    protected function prepend(): string
    {
        return $this->csrfToken !== null
            ? PHP_EOL . Input::hidden($this->csrfName, $this->csrfToken)
            : '';
    }

    protected function getName(): string
    {
        return 'form';
    }
}
