#!/bin/sh

if [ -z "$1" ]; then
  echo "Usage: $0 <URL>"
  exit 1
fi

curl -s "$1" | grep -o 'href="http[^"]*"' | cut -d'"' -f2

