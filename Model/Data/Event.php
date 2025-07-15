<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model\Data;

use Magento\Framework\Model\AbstractModel;
use Qoliber\EventCalendar\Api\Data\EventExtensionInterface;
use Qoliber\EventCalendar\Api\Data\EventInterface;

class Event extends AbstractModel implements EventInterface
{
    /**
     * Get entity ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID) ? (int) $this->getData(self::ENTITY_ID) : null;
    }

    /**
     * Set entity ID
     *
     * @param $entityId
     * @return $this
     */
    public function setEntityId($entityId): EventInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Customer ID
     *
     * @param int|null $customerId
     * @return EventInterface
     */
    public function setCustomerId(?int $customerId): EventInterface
    {
        $this->setData(self::CUSTOMER_ID, $customerId);

        return $this;
    }

    /**
     * Get Event URL
     *
     * @return string|null
     */
    public function getEventUrl(): ?string
    {
        return $this->getData(self::EVENT_URL);
    }

    /**
     * Set Event URL
     *
     * @param string|null $eventUrl
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventUrl(?string $eventUrl): EventInterface
    {
        $this->setData(self::EVENT_URL, $eventUrl);

        return $this;
    }

    /**
     * Get Event Name
     *
     * @return string|null
     */
    public function getEventName(): ?string
    {
        return $this->getData(self::EVENT_NAME);
    }

    /**
     * Set Event Name
     *
     * @param string|null $eventName
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventName(?string $eventName): EventInterface
    {
        $this->setData(self::EVENT_NAME, $eventName);

        return $this;
    }

    /**
     * Get Uuid
     *
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->getData(self::UUID);
    }

    /**
     * Set Uuid
     *
     * @param string|null $uuid
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setUuid(?string $uuid): EventInterface
    {
        $this->setData(self::UUID, $uuid);

        return $this;
    }

    /**
     * Get Date From
     *
     * @return string|null
     */
    public function getDateFrom(): ?string
    {
        return $this->getData(self::DATE_FROM);
    }

    /**
     * Set Date From
     *
     * @param string $dateFrom
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateFrom(string $dateFrom): EventInterface
    {
        $this->setData(self::DATE_FROM, $dateFrom);

        return $this;
    }

    /**
     * Get Date To
     *
     * @return string|null
     */
    public function getDateTo(): ?string
    {
        return $this->getData(self::DATE_TO);
    }

    /**
     * Set DateTo
     *
     * @param string $date_to
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateTo(string $date_to): EventInterface
    {
        $this->setData(self::DATE_TO, $date_to);

        return $this;
    }

    /**
     * Get Active
     *
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->getData(self::ACTIVE);
    }

    /**
     * Set Active
     *
     * @param string|null $active
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setActive(?string $active): EventInterface
    {
        $this->setData(self::ACTIVE, $active);

        return $this;
    }

    /**
     * Get Logo
     *
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->getData(self::LOGO);
    }

    /**
     * Set Logo
     *
     * @param string|null $logo
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setLogo(?string $logo): EventInterface
    {
        $this->setData(self::LOGO, $logo);

        return $this;
    }

    /**
     * Get URL
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->getData(self::URL);
    }

    /**
     * Set URL
     *
     * @param string $url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setUrl(string $url): EventInterface
    {
        $this->setData(self::URL, $url);

        return $this;
    }

    /**
     * Get Country
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * Set Country
     *
     * @param string|null $country
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCountry(?string $country): EventInterface
    {
        $this->setData(self::COUNTRY, $country);

        return $this;
    }

    /**
     * Get Address Details
     *
     * @return string|null
     */
    public function getAddressDetails(): ?string
    {
        return $this->getData(self::ADDRESS_DETAILS);
    }

    /**
     * Set Address details
     *
     * @param string $address_details
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setAddressDetails(string $address_details): EventInterface
    {
        $this->setData(self::ADDRESS_DETAILS, $address_details);

        return $this;
    }

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->getData(self::CITY);
    }

    /**
     * Set City
     *
     * @param string|null $city
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCity(?string $city): EventInterface
    {
        $this->setData(self::CITY, $city);

        return $this;
    }

    /**
     * Get Organizer URL
     *
     * @return string|null
     */
    public function getOrganizerUrl(): ?string
    {
        return $this->getData(self::ORGANIZER_URL);
    }

    /**
     * Set Organizer URL
     *
     * @param string|null $organizer_url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerUrl(?string $organizer_url): EventInterface
    {
        $this->setData(self::ORGANIZER_URL, $organizer_url);

        return $this;
    }

    /**
     * Get Organizer Name
     *
     * @return string|null
     */
    public function getOrganizerName(): ?string
    {
        return $this->getData(self::ORGANIZER_NAME);
    }

    /**
     * Set Organizer Name
     *
     * @param string $organizer_name
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerName(string $organizer_name): EventInterface
    {
        $this->setData(self::ORGANIZER_NAME, $organizer_name);

        return $this;
    }

    /**
     * Get Extension Attributes
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventExtensionInterface|null
     */
    public function getExtensionAttributes(): ?EventExtensionInterface
    {
        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    /**
     * Set Extension Attributes
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventExtensionInterface $extensionAttributes
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setExtensionAttributes(EventExtensionInterface $extensionAttributes): EventInterface
    {
        $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);

        return $this;
    }
}
