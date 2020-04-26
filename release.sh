#!/bin/bash
CURRDIR=$(cd "$(dirname "$0")";pwd)

for kod in kodexplorer kodbox
do
  cd ${CURRDIR}/${kod}-plugins
  zip -rq plugins-pack-for_${kod}.zip ./

  for plugin in $(find ./ -maxdepth 1 -type d ! -name .)
  do
    VERSION=$(jq -r .version ${plugin}/package.json)
    zip -rq ${plugin}-v${VERSION}-for_${kod}.zip ${plugin}
  done
done
