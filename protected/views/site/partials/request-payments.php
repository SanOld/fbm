<div id="finance" class="tab-pane" ng-controller="RequestPaymentsController">
  <div class="panel-group panel-group-joined m-0">
    <div class="panel panel-default">

      <div   class="panel-body p-t-0">
          <div class="row datafilter">

            <div class="col-lg-12">
            <form>

              <div class="col-lg-2">
                <div class="form-group">
                  <div class="form-group">
                    <label>Тип платежа</label>
                    <input ng-change="updateGrid()" type="search" ng-model="filter.code" class="form-control popup-input" placeholder="Введите тип платежа" ng-hide="user.type  == 't'">
                    <ui-select ng-change="updateGrid()" ng-model="filter.code">
                      <ui-select-match allow-clear="true" placeholder="Введите номер заказа">{{$select.selected.code}}</ui-select-match>
                      <ui-select-choices repeat="item.code as item in requests | filter: $select.search | orderBy: 'code'">
                        <span ng-bind="item.code"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 custom-lg-1">
                <div class="form-group" ng-hide="user.type  == 't'">
                  <label>Ответственный</label>
                  <ui-select ng-change="updateGrid()" ng-model="filter.manager">
                    <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.short_name}}</ui-select-match>
                    <ui-select-choices repeat="item.short_name as item in managers | filter: $select.search">
                      <span ng-bind="item.short_name"></span>
                    </ui-select-choices>
                  </ui-select>
                </div>
                </div>
              <div class="col-lg-2 custom-lg-1">
                <div class="form-group">
                  <div class="form-group">
                    <label>Валюта</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                      <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.name}}</ui-select-match>
                      <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'name'">
                        <span ng-bind="item.full_name"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <div class="form-group">
                    <label>Дата с</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.year">
                      <ui-select-match>{{$select.selected}}</ui-select-match>
                      <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: item">
                        <span ng-bind="item"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
               <div class="col-lg-2">
                <div class="form-group">
                  <div class="form-group">
                    <label>Дата по</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.year">
                      <ui-select-match>{{$select.selected}}</ui-select-match>
                      <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: item">
                        <span ng-bind="item"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>

              <div class="col-lg-2 reset-btn-width">
                <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"> <i class="fa fa-rotate-left"></i>
                  <span>Сбросить</span>
                </button>
              </div>
            </form>
            </div>
          </div>



        <div class='row'>
                <div  class="col-lg-12"  r-flex="true" >

                  <table id="datatable" ng-cloak ng-table="tableParams1" class="table dataTable table-hover table-bordered table-edit table-requests">
                    <tr ng-repeat="row in $data | filter: {code:filter.code, customer:filter.customer, manager:filter.manager, status_code:filter.status_code} " ng-class="row.status_code == 'in_progress' && (user.type == 's' || user.type == 'd' || user.type == 'g') ?
                                                           'wait-row' : row.status_code + '-row'">
                      <td header="'headerCheckbox.html'">
                        <label class="cr-styled">
                          <input type="checkbox" ng-model="checkboxes.items[row.id]">
                          <i class="fa"></i>
                        </label>
                      </td>
                      <td data-title="'Тип платежа'" sortable="'code'">{{row.code}}</td>

                      <td data-title="'Сумма'" sortable="'programm'">{{row.sum}}</td>
                      <td data-title="'Валюта'" sortable="'programm'">{{row.payed}}</td>
                      <td data-title="'Дата платежа'" sortable="'year'">{{row.date | date : 'dd.MM.yyyy'}}</td>

                      <td data-title="'Ответственный'" sortable="'manager'">{{row.manager}}</td>
                      <td data-title="'Примечание'" sortable="user.type != 't' ? 'performer_name' : 'school_name'">
                       <div class="holder-school">
                        <a  href="" target="_blank"></a>
                       </div>
                      </td>
                      <td data-title="" ng-click="setFilter()">
                        <a ng-click="printDocuments(row)"  ng-class=" {disabled: !row.can_print } " class="btn document" href="" title="Печать"><i class="ion-printer"></i></a>
                        <a ng-if="row.can_edit" class="btn edit-btn" href="/request/{{row.id}}"  title="Редактирование данных заказа">
                          <i class="ion-edit"></i>
                        </a>
                        <a ng-if="!row.can_edit" class="btn edit-btn"  href="/request/{{row.id}}" title="Просмотр данных заказа">
                          <i class="ion-eye"></i>
                        </a>
                      </td>
                    </tr>
                    <tr ng-if="!$data.length"><td class="no-result" colspan="10">Нет результатов</td></tr>
                  </table>

                  <div class="btn-row m-t-15 clearfix" ng-if="canEdit() && canByType(['a','p'])">
                    <div class="col-lg-7">
                      <button class="btn m-b-5" ng-click="alert('To Do - форма приема платежа')">Принять платеж</button>
                      <button class="btn m-b-5" >Удалить платеж</button>
                      <button class="btn m-b-5" >Возврат</button>
                    </div>
                    <div class="col-lg-3">
   
                    </div>
                  </div>
                </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/ng-template" id="headerCheckbox.html">
  <label class="cr-styled">
    <input type="checkbox" ng-model="checkboxes.checked" ng-click="headerChecked(checkboxes.checked)">
    <i class="fa"></i>
  </label>
</script>
