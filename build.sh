#!/usr/bin/env bash
YEAR=$(date +"%Y")
MONTH=$(date +"%m")
git config --global user.email "${GIT_EMAIL}"
git config --global user.name "${GIT_NAME}"
git config --global push.default simple
export GIT_TAG=V2.$YEAR-$MONTH.$TRAVIS_BUILD_NUMBER
msg="Tag Generated from TravisCI for build $TRAVIS_BUILD_NUMBER"
git add $TRAVIS_BUILD_DIR/tyche.zip
git commit -m "Update build version file with $TRAVIS_BUILD_NUMBER"