<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface EventInterface extends ExtensibleDataInterface
{
    /** @var string  */
    public const EVENT_ID = 'event_id';

    /** @var string  */
    public const EVENT_NAME = 'event_name';

    /** @var string */
    public const UUID = 'uuid';

    /** @var string  */
    public const EVENT_URL = 'event_url';

    /** @var string  */
    public const DATE_FROM = 'date_from';

    /** @var string  */
    public const DATE_TO = 'date_to';

    /** @var string  */
    public const ACTIVE = 'active';

    /** @var string  */
    public const LOGO = 'logo';

    /** @var string  */
    public const URL = 'url';

    /** @var string  */
    public const COUNTRY = 'country';

    /** @var string  */
    public const ADDRESS_DETAILS = 'address_details';

    /** @var string  */
    public const CITY = 'city';

    /** @var string  */
    public const ORGANIZER_URL = 'organizer_url';

    /** @var string  */
    public const ORGANIZER_NAME = 'organizer_name';

    /**
     * Get Id
     *
     * @return int|null
     */
    public function getEventId(): ?int;

    /**
     * Set Id
     *
     * @param int $eventId
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventId(int $eventId): EventInterface;

    /**
     * Get Event URL
     *
     * @return string|null
     */
    public function getEventUrl(): ?string;

    /**
     * Set Event URL
     *
     * @param null|string $eventUrl
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventUrl(?string $eventUrl): EventInterface;

    /**
     * Get Event Name
     *
     * @return string|null
     */
    public function getEventName(): ?string;

    /**
     * Set Event Name
     *
     * @param null|string $eventName
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setEventName(?string $eventName): EventInterface;

    /**
     * Get Event Name
     *
     * @return string|null
     */
    public function getUuid(): ?string;

    /**
     * Set Event Name
     *
     * @param null|string $uuid
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setUuid(?string $uuid): EventInterface;

    /**
     * Get Date From
     *
     * @return string|null
     */
    public function getDateFrom(): ?string;

    /**
     * Set Date From
     *
     * @param string $dateFrom
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateFrom(string $dateFrom): EventInterface;

    /**
     * Get Date To
     *
     * @return string|null
     */
    public function getDateTo(): ?string;

    /**
     * Set Date To
     *
     * @param string $date_to
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setDateTo(string $date_to): EventInterface;

    /**
     * Get Active
     *
     * @return string|null
     */
    public function getActive(): ?string;

    /**
     * Set Active
     *
     * @param null|string $active
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setActive(?string $active): EventInterface;

    /**
     * Get Logo
     *
     * @return string|null
     */
    public function getLogo(): ?string;

    /**
     * Set Logo
     *
     * @param null|string $logo
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setLogo(?string $logo): EventInterface;

    /**
     * Get URL
     *
     * @return string|null
     */
    public function getUrl(): ?string;

    /**
     * Set URL
     *
     * @param string $url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setUrl(string $url): EventInterface;

    /**
     * Get Country
     *
     * @return string|null
     */
    public function getCountry(): ?string;

    /**
     * Set Country
     *
     * @param null|string $country
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCountry(?string $country): EventInterface;

    /**
     * Get Address Details
     *
     * @return string|null
     */
    public function getAddressDetails(): ?string;

    /**
     * Set Address Details
     *
     * @param string $address_details
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setAddressDetails(string $address_details): EventInterface;

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * Set City
     *
     * @param null|string $city
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setCity(?string $city): EventInterface;

    /**
     * Get Organizer Url
     *
     * @return string|null
     */
    public function getOrganizerUrl(): ?string;

    /**
     * Set Organizer URL
     *
     * @param null|string $organizer_url
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerUrl(?string $organizer_url): EventInterface;

    /**
     * Get Organizer Name
     *
     * @return string|null
     */
    public function getOrganizerName(): ?string;

    /**
     * Set Organizer Name
     *
     * @param string $organizer_name
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setOrganizerName(string $organizer_name): EventInterface;

    /**
     * Get Extension Attributes
     *
     * @return \Qoliber\EventCalendar\Api\Data\EventExtensionInterface|null
     */
    public function getExtensionAttributes(): ?EventExtensionInterface;

    /**
     * Set Extension Attributes
     *
     * @param \Qoliber\EventCalendar\Api\Data\EventExtensionInterface $extensionAttributes
     * @return \Qoliber\EventCalendar\Api\Data\EventInterface
     */
    public function setExtensionAttributes(EventExtensionInterface $extensionAttributes): EventInterface;
}
