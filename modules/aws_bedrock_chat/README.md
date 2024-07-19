# AWS Bedrock Chat Module

The AWS Bedrock Chat Module integrates AWS-powered Generative AI functionalities into Drupal 10 websites, offering a seamless user experience for live chat interactions.

## Features

- AJAX-powered chat interface for real-time interaction.
- Configuration options for AWS credentials, including AWS Profile, Model ARN, and Region.
- Customizable chat UI with options for setting icons and colors through the Drupal admin interface.
- SVG support for high-quality, scalable icons in the chat interface.
- Dependency injection for core services to ensure modularity and testability.
- Powered by Retrieve and Generate functionality available with Anthropic Claude models.

## Installation

1. **Download the Module**:

   Download from this Drupal.org project page or use Composer to download the module and its dependencies:
   
   ```bash
   composer require drupal/aws_bedrock_chat
   ```

   Then, enable the module via the extend page or with Drush:
   ```
   drush en aws_bedrock_chat
   ```

2. **Requirements**:

   If installing with composer the AWS SDK dependencies will automatically be installed. See [Install the AWS SDK for PHP](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/getting-started_installation.html "Installation for AWS SDK for PHP") for additional instructions for downloading the AWS SDK.

## Configuration

Navigate to the Drupal admin interface, and go to Configuration > Web services > AWS Bedrock Chat Settings (/admin/config/services/aws-bedrock-chat). Fill in the necessary AWS configurations.

## Permissions

Set appropriate permissions for the module under People > Permissions (/admin/people/permissions), ensuring only authorized roles can manage chat settings. Default configuration page is available for any user with the `administer site configuration` permission.
- **Configure AWS Bedrock Chat**: Allows users to configure AWS Bedrock Chat settings.
- **Customize AWS Bedrock Chat**: Allows users to customize the appearance of the AWS Bedrock Chat interface.
- **Translate AWS Bedrock Chat**: Allows users to translate AWS Bedrock Chat interface and messages.

## Authentication

AWS Bedrock service can be authenticated via:

- **Profiles**: AWS profiles configured on the host machine.
- **Keys**: Access and secret keys can be provided in the UI or via environment variables.
  ```
  AWS_ACCESS_KEY_ID
  AWS_SECRET_ACCESS_KEY
  ```
  >[!] Note: For enhanced security, it's recommended to use environment variables instead of storing keys in the database.
- **Environment Variables**: Environment variables set on the host machine or injected via sessions (i.e. AWS Vault).
    ```
    AWS_REGION
    AWS_DEFAULT_REGION
    AWS_ACCESS_KEY_ID
    AWS_SECRET_ACCESS_KEY
    AWS_SESSION_TOKEN
    AWS_CREDENTIAL_EXPIRATION
    ```

## Usage

### Block Layout

Once configured, the AWS Bedrock Chat block can be placed in any region through the block layout interface (/admin/structure/block). After placement the chat interface will appear in the selected region and will be fixed to the bottom right by default. Additional page or role visibility can be set through the block configuration.

### Twig Template

With the [Twig Tweak](https://www.drupal.org/project/twig_tweak) module enabled, you can render your block on your theme's template with the following code:

```
{{ drupal_block('aws_bedrock_chat_block') }}
```

## Customization

### Chat Interface
Customize the appearance and behavior of the chat interface through the module's configuration page. Options include:

Icons: Upload or link to icons for user and response messages, chat toggle button and ajax loading gif.


Colors and Styles: Define colors for elements of the chat UI, including background, border and text colors.

### Advanced Customizations
For more in-depth customizations, such as altering the chat interface's layout or functionality:

Twig Templates: Override the module's Twig templates in your theme for custom layouts.
CSS/JS: Add custom stylesheets or JavaScript files to your theme to further customize the appearance and behavior.
SVG Icons: Use inline SVGs for chat icons to allow CSS styling of the SVG elements, enabling dynamic color changes or animations.

### Development Best Practices

AJAX Forms: The chat form leverages Drupal's AJAX API for a non-refreshing chat experience, improving usability and performance.

Twig Templates: Custom Twig templates are utilized for rendering parts of the chat interface, allowing easy customization and adherence to Drupal's theming system.

Security: All user inputs and configurations are sanitized, and permissions are carefully managed to allow access to be granted to different roles as needed.

## Contributing

Contributions to the AWS Bedrock Chat module are welcome. Please follow Drupal's coding standards and best practices for module development.

Issue Reporting: Report issues via the Drupal module's issue queue.
Patches and Features: Submit patches or feature requests through the issue queue, adhering to Drupal's patch submission guidelines.
Documentation: Improvements to documentation or README files are appreciated.
