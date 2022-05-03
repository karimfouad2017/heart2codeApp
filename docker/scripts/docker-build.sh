#!/usr/bin/env bash

set -e

USER="${DOCKER_USER}"
PASSWD="${DOCKER_PASS}"

PROJECT_NAME=${DOCKER_PROJECT_NAME}

TAG=$(git tag --points-at HEAD)

if [[ ! -n ${TAG} ]]
then
    TAG=$(git rev-parse --abbrev-ref HEAD | sed 's/\//_/g')
fi


if [[ ! -z ${GITHUB_TOKEN} ]]
then
    echo "Creating local auth.json file"

    cat > auth.json <<EOL
    {
        "github-oauth": {
            "github.com": "${GITHUB_TOKEN}"
        }
    }
EOL
else
     echo "Not creating a local auth.json file - no GitHub token supplied"
fi

echo "Building docker image tagged with branch name - ${TAG}"

docker build . --tag=${PROJECT_NAME}:${TAG}

echo "Logging into docker"

docker login --username ${USER} --password ${PASSWD}

echo "Pushing to docker hub"

docker push opendialogai/opendialog:${TAG}

echo "Finished"
