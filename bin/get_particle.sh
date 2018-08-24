#!/usr/bin/env bash

# Code from https://stackoverflow.com/questions/24987542/is-there-a-link-to-github-for-downloading-a-file-in-the-latest-release-of-a-repo/29360657

# Use the github release API to grab the tarball_url.
# Using head to get the latest release instead of /latest since we want the latest alpha/beta version
URL=$(curl -s https://api.github.com/repos/phase2/particle/releases | grep tarball_url | head -n 1 | cut -d '"' -f 4)
# If you just want the latest stable release, use this:
# URL=$(curl -s https://api.github.com/repos/phase2/particle/releases/latest | grep tarball_url | cut -d '"' -f 4)

# Download the tarball and extract it to the particle theme folder
THEME_PATH="src/themes/particle"
mkdir "$THEME_PATH"
# Use strip-components to remove top folder from tarball since we
# want "particle" to be the top level name.
curl -L -s $URL | tar xz -C $THEME_PATH --strip-components=1
