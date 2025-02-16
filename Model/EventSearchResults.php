<?php
/**
 * Created by Qoliber
 *
 * @category    Qoliber
 * @package     Qoliber_EventCalendar
 * @author      Jakub Winkler <jwinkler@qoliber.com>
 */

declare(strict_types=1);

namespace Qoliber\EventCalendar\Model;

use Magento\Framework\Api\SearchResults;
use Qoliber\EventCalendar\Api\Data\EventSearchResultsInterface;

class EventSearchResults extends SearchResults implements EventSearchResultsInterface
{

}
