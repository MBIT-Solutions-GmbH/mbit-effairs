<?php
namespace MBIT\MbitEffairs\Tests\Unit\Controller;

/**
 * Test case.
 */
class SubscriberControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \MBIT\MbitEffairs\Controller\SubscriberController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\MBIT\MbitEffairs\Controller\SubscriberController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenSubscriberToSubscriberRepository()
    {
        $subscriber = new \MBIT\MbitEffairs\Domain\Model\Subscriber();

        $subscriberRepository = $this->getMockBuilder(\MBIT\MbitEffairs\Domain\Repository\SubscriberRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $subscriberRepository->expects(self::once())->method('add')->with($subscriber);
        $this->inject($this->subject, 'subscriberRepository', $subscriberRepository);

        $this->subject->createAction($subscriber);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenSubscriberFromSubscriberRepository()
    {
        $subscriber = new \MBIT\MbitEffairs\Domain\Model\Subscriber();

        $subscriberRepository = $this->getMockBuilder(\MBIT\MbitEffairs\Domain\Repository\SubscriberRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $subscriberRepository->expects(self::once())->method('remove')->with($subscriber);
        $this->inject($this->subject, 'subscriberRepository', $subscriberRepository);

        $this->subject->deleteAction($subscriber);
    }
}
