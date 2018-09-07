<?php
/**
 * See LICENSE.md for license details.
 */
namespace Dhl\ExpressRates\Model\Data\Form\Element;

use Magento\Framework\Data\Form\Element\Radios;

/**
 * Class Radioset
 *
 * Implementation of a radio set input element that works inside the Magento system configuration.
 * Used by entering the class name into the "type" attribute of a system.xml field element.
 *
 * @package Dhl\ExpressRates\Model
 */
class Radioset extends Radios
{
    const PSEUDO_POSTFIX = '_pseudo'; // used to create the hidden input id.

    /**
     * Add a display none style since the css directive that hides the original input element is missing in
     * system_config.
     *
     * @param mixed $value
     * @return string
     */
    public function getStyle($value)
    {
        return 'display:none';
    }

    /**
     * @return string
     */
    public function getElementHtml()
    {
        $this->setData('after_element_html', $this->getSecondaryLabelHtml() . $this->getJsHtml());

        return parent::getElementHtml();
    }

    /**
     * Add a hidden input whose value is kept in sync with the checked status of the checkbox.
     *
     * @return string
     */
    private function getJsHtml()
    {
        $hiddenId = $this->getHtmlId() . self::PSEUDO_POSTFIX;

       return <<<HTML
<input type="hidden" id="{$hiddenId}" name="{$this->getName()}" value="{$this->getData('value')}"/>
<script>
    (function() {
        let radios = document.querySelectorAll("input[type=\"radio\"][name=\"{$this->getName()}\"]");
        let hidden = document.getElementById("{$hiddenId}");

        radios.forEach((radio) => {
            if (radio.type === "radio") {
                radio.name += "[pseudo]";

                // keep the hidden input value in sync with the radio. We also update the radio value because
                // it may be needed by the core.
                //
                // @see module-backend/view/adminhtml/templates/system/shipping/applicable_country.phtml
                radio.addEventListener("change", function (event) {
                    hidden.value = event.target.value;
                });
            }
        });
    })();
</script>
HTML;
    }

    /**
     * @return string
     */
    private function getSecondaryLabelHtml()
    {
        $html = '<label for="%s" class="admin__field-label">%s</label>';

        return sprintf(
            $html,
            $this->getHtmlId(),
            $this->getButtonLabel()
        );
    }
}
