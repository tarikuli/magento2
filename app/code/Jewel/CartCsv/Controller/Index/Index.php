<?php
namespace Jewel\CartCsv\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    protected $fileFactory;

    protected $csvProcessor;

    protected $directoryList;

    protected $_logger;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\File\Csv $csvProcessor, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->directoryList = $directoryList;
        $this->fileFactory = $fileFactory;
        $this->csvProcessor = $csvProcessor;
        parent::__construct($context);
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $this->_logger = new \Zend\Log\Logger();
        $this->_logger->addWriter($writer);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $itemsCollection = $cart->getQuote()->getItemsCollection();
        
        $result[] = [
            'sku',
            'name',
            'price',
            'qty',
            'subtotal'
        ];
        foreach ($itemsCollection as $record) {
            if ($record->getParentItemId() == null) {
                $record->setId($record->getitem_id());
                $result[] = [
                    $record->getSku(),
                    $record->getName(),
                    $record->getPrice(),
                    $record->getQty(),
                    ($record->getQty() * $record->getPrice())
                ];
            }
        }
        
        $fileName = 'cart_csv.csv';
        $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR) . "/" . $fileName;
        
        $this->csvProcessor->setDelimiter(';')
            ->setEnclosure('"')
            ->saveData($filePath, $result);
        
        return $this->fileFactory->create($fileName, [
            'type' => "filename",
            'value' => $fileName,
            'rm' => true
        ], \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR, 'application/octet-stream');
        return $result;
    }
}
