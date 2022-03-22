<?php
declare(strict_types=1);

namespace Magelearn\Customform\Block\Adminhtml\Customform\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeclineButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getModelId()) {
            $data = [
                'label' => __('Decline'),
                'class' => 'save primary',
                'on_click' => sprintf("location.href = '%s';", $this->getDeclineUrl()),
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeclineUrl()
    {
        return $this->getUrl('*/*/decline', ['id' => $this->getModelId()]);
    }
}

