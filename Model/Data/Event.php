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

use Magento\Framework\Api\AbstractExtensibleObject;
use Qoliber\EventCalendar\Api\Data\EventExtensionInterface;
use Qoliber\EventCalendar\Api\Data\EventInterface;

class Event extends AbstractExtensibleObject implements EventInterface
{
    /**
     * Get Entity ID
     *
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * Set Entity ID
     *
     * @param int $entity_id
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEntityId(int $entity_id): EventInterface
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * Get Event URL
     *
     * @return string|null
     */
    public function getEventUrl(): ?string
    {
        return $this->_get(self::EVENT_URL);
    }

    /**
     * Set Event URL
     *
     * @param string|null $eventUrl
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventUrl(?string $eventUrl): EventInterface
    {
        return $this->setData(self::EVENT_URL, $eventUrl);
    }

    /**
     * Get Event Name
     *
     * @return string|null
     */
    public function getEventName(): ?string
    {
        return $this->_get(self::EVENT_NAME);
    }

    /**
     * Set Event Name
     *
     * @param string|null $eventName
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventName(?string $eventName): EventInterface
    {
        return $this->setData(self::EVENT_NAME, $eventName);
    }

    /**
     * Get Date From
     *
     * @return string|null
     */
    public function getDateFrom(): ?string
    {
        return $this->_get(self::DATE_FROM);
    }

    /**
     * Set Date From
     *
     * @param string $dateFrom
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateFrom(string $dateFrom): EventInterface
    {
        return $this->setData(self::DATE_FROM, $dateFrom);
    }

    /**
     * Get Date To
     *
     * @return string|null
     */
    public function getDateTo(): ?string
    {
        return $this->_get(self::DATE_TO);
    }

    /**
     * Set DateTo
     *
     * @param string $date_to
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateTo(string $date_to): EventInterface
    {
        return $this->setData(self::DATE_TO, $date_to);
    }

    /**
     * Get Active
     *
     * @return string|null
     */
    public function getActive(): ?string
    {
        return $this->_get(self::ACTIVE);
    }

    /**
     * Set Active
     *
     * @param string|null $active
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setActive(?string $active): EventInterface
    {
        return $this->setData(self::ACTIVE, $active);
    }

    /**
     * Get Logo
     *
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->_get(self::LOGO);
    }

    /**
     * Set Logo
     *
     * @param string|null $logo
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setLogo(?string $logo): EventInterface
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * Get URL
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->_get(self::URL);
    }

    /**
     * Set URL
     *
     * @param string $url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setUrl(string $url): EventInterface
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * Get Country
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->_get(self::COUNTRY);
    }

    /**
     * Set Country
     *
     * @param string|null $country
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCountry(?string $country): EventInterface
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * Get Address Details
     *
     * @return string|null
     */
    public function getAddressDetails(): ?string
    {
        return $this->_get(self::ADDRESS_DETAILS);
    }

    /**
     * Set Address details
     *
     * @param string $address_details
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setAddressDetails(string $address_details): EventInterface
    {
        return $this->setData(self::ADDRESS_DETAILS, $address_details);
    }

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->_get(self::CITY);
    }

    /**
     * Set City
     *
     * @param string|null $city
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCity(?string $city): EventInterface
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get Organizer URL
     *
     * @return string|null
     */
    public function getOrganizerUrl(): ?string
    {
        return $this->_get(self::ORGANIZER_URL);
    }

    /**
     * Set Organizer URL
     *
     * @param string|null $organizer_url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerUrl(?string $organizer_url): EventInterface
    {
        return $this->setData(self::ORGANIZER_URL, $organizer_url);
    }

    /**
     * Get Organizer Name
     *
     * @return string|null
     */
    public function getOrganizerName(): ?string
    {
        return $this->_get(self::ORGANIZER_NAME);
    }

    /**
     * Set Organizer Name
     *
     * @param string $organizer_name
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerName(string $organizer_name): EventInterface
    {
        return $this->setData(self::ORGANIZER_NAME, $organizer_name);
    }

    /**
     * Get Extension Attributes
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventExtensionInterface
     */
    public function getExtensionAttributes(): EventExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set Extension Attributes
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        EventExtensionInterface $extensionAttributes
    ): static {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
