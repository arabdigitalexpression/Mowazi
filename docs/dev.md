# Development Notes and Project Architecture

## Development Notes

This section contains detailed development notes, including updates, changes, and important information related to the project's ongoing development.

### Bug Fixes

- **[Bug ID]**: Description of the bug and how it was resolved.
- **[Bug ID]**: Description of another bug and its resolution details.

### Enhancements

- **[Enhancement ID]**: Description of the enhancement and how it was implemented.
- **[Enhancement ID]**: Description of another enhancement and its implementation details.

## Project Architecture

This section provides an overview of the project's architecture, including content types, frontend, and backend code organization.

### Content Types Diagram

Below is a diagram representing the existing WordPress content types in Mowazi:

### Frontend Code

The frontend code is organized as follows:

- **`/public`**: Contains public assets such as stylesheets, images, and client-side JavaScript files.
- **`/src/components`**: Reusable UI components used throughout the application.
- **`/src/pages`**: Individual pages of the application, each corresponding to a specific route.
- **`/src/utils`**: Utility functions and helper scripts.

### Backend Code

The backend code is organized as follows:

- **`/server`**: Main server files and configurations.
- **`/server/routes`**: API routes for handling requests related to articles, activities, workshops, games, and stories.
- **`/server/models`**: Database models for different content types.
- **`/server/controllers`**: Controllers for processing requests and interacting with the database.
- **`/server/config`**: Configuration files, including database configuration and environment variables setup.

---

Feel free to update this file with additional development notes, bug fixes, or architectural changes as the project progresses.

*This document is maintained and updated by the development team. For any questions or clarifications, please contact the project maintainers.*
