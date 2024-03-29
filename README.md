# EasyLoraWebShop

The EasyLoraWebShop offers a simple and elegant way to store and display your LoRa files. For each LoRa, a preview image is shown, and clicking on this preview image reveals the corresponding metadata of the LoRa. This functionality assumes that the LoRa has been created following established standards, providing specific data regarding tags and folders. If the create_meta script generates an empty .txt file, it indicates that no corresponding metadata was included in the safetensor file.

Below each image, you'll find the name of the LoRa and a download link.

Caution: The primary use of this system is intended for a local network environment, as it lacks authentication and validation mechanisms. Hotlinking is possible, which could impact your bandwidth. Please keep this in mind when using the script.

The script itself doesn't require sophisticated hardware or complex configuration. In my case, it runs smoothly on a small NAS with a minimal Apache server setup. A Raspberry Pi with sufficient storage should also be capable of handling this without any issues.

If you have any questions, feel free to post them. I'll respond as quickly as I can.

## File Structure

The framework operates on a straightforward directory structure at the root level, managing three primary folders:

- `safetensors/` - Contains safetensor files, which are the data files for LoRa projects.
- `metadata/` - Stores metadata files in `.txt` format, extracted from the safetensor files.
- `images/` - Holds `.png` images that correspond to each safetensor file for preview purposes.

## Key Scripts

### `index.php`

The main entry point of the EasyLoraWebShop, `index.php` orchestrates the display of the gallery, the initiation of metadata refresh, and serves as the interface for user interaction.

- **Features:**
  - Dynamically loads and displays gallery images from the `images/` directory.
  - Provides a "Refresh Metadata" button that triggers the metadata generation process.

### `create_meta.php`

A sidecar script that extracts metadata from safetensor files and generates corresponding `.txt` files in the `metadata/` directory.

- **Usage:**
  - Automatically called via `index.php`. It requires no direct user interaction.
  - Processes each `.safetensors` file in the `safetensors/` directory to generate a `.txt` file in the `metadata/` directory.

### `info.php`

Displays detailed metadata for a specific LoRa project. It requires a `modelname` query parameter, which is passed from the `index.php`.

- **Functionality:**
  - Renders a detailed view of a project's metadata based on the `modelname` parameter.

## Workflow Example

1. Place safetensor files in the `safetensors/` directory.
2. Access the EasyLoraWebShop via `index.php` and click on "Refresh Metadata" at the top left. A new tab with status information will open (can be closed afterward).
3. For each safetensor file, a corresponding metadata `.txt` file is created in the `metadata/` directory.
4. Place a corresponding preview image in the `images/` directory, with one image per safetensor file. The image name should match the safetensor and metadata file names.

   Example:
   - `lora1.safetensors` -> `safetensors/`
   - `lora1.safetensors.txt` -> `metadata/`
   - `lora1.png` -> `images/`

Upon completing these steps, the web interface will display a gallery of LoRa projects. Clicking on an image reveals the metadata and offers options for download, providing a quick and efficient way to manage and showcase LoRa projects.
