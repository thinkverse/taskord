#!/bin/bash

opened_merge_requests=$(curl -H "Authorization: Bearer $ACCESS_TOKEN" https://gitlab.com/api/v4/projects/"$PROJECT_ID"/merge_requests?state=opened)

for iid in $(echo "$opened_merge_requests" | jq '.[] | .iid'); do
  curl -X PUT -H "Authorization: Bearer $ACCESS_TOKEN" https://gitlab.com/api/v4/projects/"$PROJECT_ID"/merge_requests/"$iid"/rebase
done
