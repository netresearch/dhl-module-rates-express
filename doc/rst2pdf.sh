#!/bin/bash

scriptPath="`dirname \"$0\"`"
scriptPath="`( cd \"$scriptPath\" && pwd )`"

echo "Building setup guide"
rst2pdf -b 1 -o "$scriptPath/SetupDocumentation.pdf" -s "$scriptPath/src/netresearch.style" "$scriptPath/src/setupDoc.rst" --real-footnotes

echo "Building user guide"
rst2pdf -b 1 -o "$scriptPath/UserDocumentation.pdf" -s "$scriptPath/src/netresearch.style" "$scriptPath/src/userDoc.rst" --real-footnotes

echo "Done"
