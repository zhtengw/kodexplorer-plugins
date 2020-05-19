#!/bin/bash
CURRDIR=$(cd "$(dirname "$0")";pwd)

for kod in kodexplorer kodbox
do
  cd ${CURRDIR}/${kod}-plugins

  # Clean up old release zip
  find ./ -maxdepth 1  -name "*.zip" -print0 | xargs -0 rm

  zip -rq plugins-pack-$(date "+%Y.%m.%d")-for_${kod}.zip ./

  for plugin in $(find ./ -maxdepth 1 -type d ! -name .)
  do
    VERSION=$(jq -r .version ${plugin}/package.json)
    zip -rq ${plugin}-v${VERSION}-for_${kod}.zip ${plugin}
  done
done
