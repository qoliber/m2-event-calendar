# Changelog

All notable changes to the Qoliber Event Calendar module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [1.1.0] - 2025-06-24

### Changed
- Module updates for improved compatibility with other Qoliber modules
- Open source module fixes and adjustments

## [1.0.0] - 2025-02-16

### Added
- Initial release of Event Calendar module
- Complete event management system with admin UI grid and form
- Frontend event submission form with customer registration capability
- Event listing page with timeline visualization
- Event information fields:
  - Event name and URL for external event pages
  - Date range selection (date_from and date_to)
  - Event logo image upload functionality
  - Location details including country, city, and full address
  - Organizer name and website URL
- Customer association system linking events to Magento customers
- UUID generation for unique event identification
- Active/inactive status toggle for event publishing control
- Frontend event display with timeline-based layout
- Separate layouts and templates for Luma and Hyva themes:
  - Luma: Standard event display with Less-based styling
  - Hyva: AlpineJS-enhanced event display with responsive timeline
- Custom styling with timeline visualization component
- SVG icon integration (calendar, location, info icons)
- Admin UI components:
  - Event listing grid with search and filters
  - Event form with image uploader
  - Mass delete action for bulk management
- Frontend controllers:
  - Event listing page
  - New event submission form
  - Event creation with customer validation
- Database schema with foreign key to customer entity
- Fulltext index on location fields for improved search
- Form validation and data sanitization
- ACL permissions for admin event management
- Admin menu integration under dedicated Events section
- ReCAPTCHA integration for frontend form submissions
- System configuration for event calendar settings
- Frontend event observers for form processing
