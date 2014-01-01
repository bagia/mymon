<div class="content">
    <h3>My watchdogs</h3>
    <div><a href="/#/new">new</a> | <a href="/#/power">power</a> | <a href="javascript:void()" ng-click="delete_power()">delete power</a></div>
    <div id="accordion">
            <h3 ng-repeat-start="watchdog in watchdogs" accordion-directive>
                #{{watchdog.id}}

                <span ng-hide="watchdog.editing">{{watchdog.name}}</span>
                <input ng-show="watchdog.editing" type="text" ng-model="watchdog.name" class="inline-edit" />
                <a ng-show="watchdog.editing" ng-click="save(watchdog)" class="link">save</a>
                <a ng-hide="watchdog.editing" ng-click="edit(watchdog)" class="link">edit</a>

                {{watchdog.history_count | parenthesis}}
            </h3>
            <div class="watchdog-detail" id="wd-{{watchdog.id}}" ng-repeat-end>
                <div class="summary">
                    <div class="history-count">Number of visits: {{watchdog.history_count}}</div>
                    <div class="delete-link"><a ng-click="delete(watchdog.id)" class="link">delete</a></div>
                </div>
                <div class="history">
                    <h4>History</h4>
                    <ul>
                        <li ng-repeat="history in watchdog.history">A hit was recorded on <b>{{history.date}}</b></b></li>
                    </ul>
                </div>
            </div>
    </div>
</div>

