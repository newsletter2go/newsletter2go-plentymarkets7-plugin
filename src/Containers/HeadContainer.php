<?php

namespace Newsletter2Go\Containers;

use IO\Services\CustomerService;
use IO\Services\TemplateService;
use IO\Services\WebstoreConfigurationService;
use Plenty\Modules\Item\Variation\Contracts\VariationRepositoryContract;
use Plenty\Modules\Order\Contracts\OrderRepositoryContract;
use Plenty\Modules\Order\Models\Order;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\ConfigRepository;

class HeadContainer
{
    /**
     * HeadContainer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Twig $twig
     * @param WebstoreConfigurationService $webStoreConfig
     * @param TemplateService $templateService
     * @param OrderRepositoryContract $orderRepositoryContract
     * @param CustomerService $customerService
     * @param VariationRepositoryContract $variationRepository
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function call(
        Twig $twig,
        WebstoreConfigurationService $webStoreConfig,
        TemplateService $templateService,
        OrderRepositoryContract $orderRepositoryContract,
        CustomerService $customerService,
        VariationRepositoryContract $variationRepository,
        ConfigRepository $configRepository
    )
    {
        $customerId = $customerService->getContactId();
        $storeConf = $webStoreConfig->getWebstoreConfig();
        $currentTemplate = $templateService->getCurrentTemplate();
        $companyId = $configRepository->get('newsletter2go.company_id');

        switch ($currentTemplate) {
            case 'tpl.confirmation':
                $currentPage = 'buyout';
                break;
            default:
                $currentPage = '';
                break;
        }

        if ($currentTemplate === 'tpl.confirmation') {

            $orderDetails = [];
            $revenue = 0;
            /** @var Order $order */
            $order = $orderRepositoryContract->getLatestOrderByContactId($customerId);
            $orderArray = $order->toArray();

            foreach ($orderArray['orderItems'] as $orderItem) {
                if ($orderItem['id'] == 0) {
                    continue;
                }

                $amount = isset($orderItem['amounts'][0]) ? $orderItem['amounts'][0] : null;
                $price = $amount ? $amount['priceGross'] : 0;
                $currency = $amount ? $amount['currency'] : '';

                $variation = $variationRepository->findById($orderItem['itemVariationId']);
                if (!$variation) {
                    continue;
                }

                $revenue += $price;

                $orderDetails[] = [
                    'id' => $variation->itemId,
                    'name' => $variation->name,
                    'qty' => $orderItem['quantity'],
                    'price' => $price,
                    'currency' => $currency,
                ];
            }

            $revenue = number_format((float)$revenue, 2, '.', '');

            $template = [
                'shopName' => $storeConf->name,
                'company_id' => $companyId,
                'order' => $order,
                'revenue' => $revenue,
                'orderData' => json_encode($orderDetails),
                'currentPage' => $currentPage,
                'customerId' => (int)$customerId,
            ];

            return $twig->render('Newsletter2Go::content.head', $template);
        }

        return '';
    }
}