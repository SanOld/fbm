<?php
$this->
        pageTitle = 'Заказы | ' . Yii::app()->name;
$this->breadcrumbs = array('Заказы');
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/requests.js"></script>


<div ng-controller="RequestController" class="wraper container-fluid"  ng-cloak>
  <div class="row">
    <div class="container-fluid center-block">
      <div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">        
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Заказы</h1>
          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()" title="Печать">
              Печать <i class="ion-printer"></i>
            </a>
            <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Экспорт</button>
            <button <?php $this->demo();?> ng-if="canByType(['a'])" ng-click="addRequest()" class="btn w-lg custom-btn" data-modal="">Создать заказ</button>
          </div>
        </div>
        <div class="panel-body request-edit">
          <div class="row datafilter">
            <div class="col-lg-2">

            </div>
            <div class="col-lg-10">
            <form>
              <div class="col-lg-2">
                <div class="form-group" ng-hide="user.type  == 't'">
                  <label>Клиент</label>
                  <ui-select ng-change="updateGrid()" ng-model="filter.customer">
                    <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.short_name}}</ui-select-match>
                    <ui-select-choices repeat="item.short_name as item in customers | filter: $select.search">
                      <span ng-bind="item.short_name"></span>
                    </ui-select-choices>
                  </ui-select>
                </div>  
                </div>
         
              <div class="col-lg-2">
                <div class="form-group">
                  <div class="form-group">
                    <label>Поиск по коду</label>
                    <input ng-change="updateGrid()" type="search" ng-model="filter.code" class="form-control popup-input" placeholder="Kennziffer eingegeben" ng-hide="user.type  == 't'">
                    <ui-select ng-change="updateGrid()" ng-model="filter.code">
                      <ui-select-match allow-clear="true" placeholder="Введите номер заказа">{{$select.selected.code}}</ui-select-match>
                      <ui-select-choices repeat="item.code as item in requests | filter: $select.search | orderBy: 'code'">
                        <span ng-bind="item.code"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 custom-lg-1">
                <div class="form-group" ng-hide="user.type  == 't'">
                  <label>Менеджер</label>
                  <ui-select ng-change="updateGrid()" ng-model="filter.manager">
                    <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.short_name}}</ui-select-match>
                    <ui-select-choices repeat="item.short_name as item in managers | filter: $select.search">
                      <span ng-bind="item.short_name"></span>
                    </ui-select-choices>
                  </ui-select>
                </div>
                </div>
              <div class="col-lg-1 custom-lg-1">
                <div class="form-group">
                  <div class="form-group">
                    <label>Изделие</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                      <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.name}}</ui-select-match>
                      <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'name'">
                        <span ng-bind="item.full_name"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-1">
                <div class="form-group">
                  <div class="form-group">
                    <label>Год</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.year">
                      <ui-select-match>{{$select.selected}}</ui-select-match>
                      <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: item">
                        <span ng-bind="item"></span>
                      </ui-select-choices>                      
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 custom-lg-1">
                <div class="form-group">
                  <div class="form-group">
                    <label>Состояние</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.status_code">
                      <ui-select-match allow-clear="true" placeholder="Просмотр всех">{{$select.selected.name}}</ui-select-match>
                      <ui-select-choices repeat="item.code as item in statuses | filter: $select.search | orderBy: 'name'">
                        <span ng-bind="item.name"></span>
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

          <div  class="flex-row">

            <div  class="col-lg-2" resizable r-directions="['right']"  r-flex="true" >
              <div class="panel panel-default">
                <div class="panel-heading-small">
                  Группы заказов
                </div>
                <div class="panel-body-small">
                  <div ui-tree>
                    <ol ui-tree-nodes="" ng-model="tree" id="tree-root">
                      <li ng-repeat="node in tree" ui-tree-node ng-include="'nodes_renderer.html'"></li>
                    </ol>
                  </div>
                  <abn-tree
                      tree-data         = "my_treedata"
                      tree-control      = "my_tree"
                      icon-leaf         = "icon-file"
                      icon-expand       = "glyphicon glyphicon-folder-close"
                      icon-collapse     = "glyphicon glyphicon-folder-open"
                      on-select         = "my_tree_handler(branch)"
                      expand-level      = "2"
                      initial-selection = "Vegetable">
                  ></abn-tree>
                </div>
              </div>
            </div>

          
            <div  class="col-lg-10"  r-flex="true" >

              <table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit table-requests">
                <tr ng-repeat="row in $data | filter: {code:filter.code, customer:filter.customer, manager:filter.manager, status_code:filter.status_code} " ng-class="row.status_code == 'in_progress' && (user.type == 's' || user.type == 'd' || user.type == 'g') ?
                                                       'wait-row' : row.status_code + '-row'">
                  <td header="'headerCheckbox.html'">
                    <label class="cr-styled">
                      <input type="checkbox" ng-model="checkboxes.items[row.id]">
                      <i class="fa"></i>
                    </label>
                  </td>
                  <td data-title="'Номер'" sortable="'code'">{{row.code}}</td>
                  <td data-title="'Клиент'" sortable="user.type != 't' ? 'performer_name' : 'school_name'">
                    <!--<span class="performer-icon" ng-class="{'unchecked':row.performer_is_checked != '1'}">{{row.performer_name}}</span>-->
                   <div class="holder-school">
                    <a  href="" target="_blank">{{row.customer}}</a>
                   </div>
                  </td>
                  <td data-title="'Сумма'" sortable="'programm'">{{row.sum}}</td>
                  <td data-title="'Оплата'" sortable="'programm'">{{row.payed}}</td>
                  <td data-title="'Задолженность'" sortable="'programm'">{{row.debt}}</td>
                  <td data-title="'Дата заказа'" sortable="'year'">{{row.date | date : 'dd.MM.yyyy'}}</td>
                  <td data-title="'Дата сдачи'" sortable="'end_fill'">{{row.end_date | date : 'dd.MM.yyyy'}}</td>
                  <td data-title="'Состояние'" sortable="'status_name'">
                      {{(row.status_code == 'in_progress' )                       ? 'В работе'              :
                        (row.status_code == 'accept'  )                           ? 'Утвержден'              :
                        (row.status_code == 'acceptable' )                        ? 'Завершен' :
                        (row.status_code == 'deactivate'      )                   ? 'Отменен' :
                        (row.status_code == 'wait'       )                        ? 'Отложен' :
                        (row.status_code == 'created'       )                     ? 'Создан' :
                         ''}}
                  </td>
                  <td data-title="'Состояние частей'">
                    <div class="col-lg-4 p-0">
                      <a class="request-button edit-btn" href="/request/{{row.id}}#finance-plan" title="Финансы">
                        <span class="cell-finplan status-icon" ng-class="row.status_finance"></span>
                      </a>
                    </div>
                    <div class="col-lg-4 p-0">
                      <a class="request-button edit-btn" href="/request/{{row.id}}#school-concepts" title="Производство">
                        <span class="cell-concept status-icon" ng-class="row.status_concept"></span>
                      </a>
                    </div>
                    <div  class="col-lg-4 p-0">
                      <a class="request-button edit-btn" href="/request/{{row.id}}#schools-goals" title="Установка">
                        <span class="cell-school status-icon" ng-class="row.status_goal"></span>
                      </a>
                    </div>
                  </td>
                  
                  <td data-title="'Менеджер'" sortable="'manager'">{{row.manager}}</td>
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
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="chooseDocuments()">Шаблоны документов</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkDuration()">Смена даты</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(4)">Подготовлен</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(5)">В производстве</button>
                </div>
                <div class="col-lg-3">
                  <button class="btn m-b-5" ng-click="export()">Экспорт данных</button>
                </div> 
                <div class="col-lg-2">
                  <button class="btn m-b-5"  ng-disabled="!existsSelected()" ng-click="copyRequest()" disabled>Копирование заказа</button>
                </div>
              </div>
            </div>
          
          </div>
  
          <div class="clearfix">
            <div class="notice {{status.code == 'decline' ? 'decline-div' : ''}}" ng-repeat="status in statuses | filter:{virtual: 0}">
              <span class="color-notice" ng-class="status.code+'-row'"></span>
              {{status.name}}
            </div>
          </div>
          <div class="clearfix square-legend">
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan unfinished status-icon"></span>
                <span class="cell-concept unfinished status-icon"></span>
                <span class="cell-school unfinished status-icon"></span>
              </div>
              В работе
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan in_progress status-icon"></span>
                <span class="cell-concept in_progress status-icon"></span>
                <span class="cell-school in_progress status-icon"></span>
              </div>
              На проверке
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan accepted status-icon"></span>
                <span class="cell-concept accepted status-icon"></span>
                <span class="cell-school accepted status-icon"></span>
              </div>
              Принят{{user.type == 't' ? ' – Zielvereinbarung drucken' : ''}} 
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan rejected status-icon"></span>
                <span class="cell-concept rejected status-icon"></span>
                <span class="cell-school rejected status-icon"></span>
              </div>
              Отклонен
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row -->
</div>

<script type="text/ng-template" id="headerCheckbox.html">
  <label class="cr-styled">
    <input type="checkbox" ng-model="checkboxes.checked" ng-click="headerChecked(checkboxes.checked)">
    <i class="fa"></i>
  </label>
</script>

<script type="text/ng-template" id="printDocuments.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Dokumente drucken - {{::code}}</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body">
      <h3 class="m-b-30 text-center">Dokumente zum Druck wählen</h3>
      <div ng-repeat="template in templates" class="doc-print" ng-hide="!userCan || (user.type == 't' && user.is_finansist != '1' && template.type_name != 'Zielvereinbarung') ">
        <div class="holder-doc-print">
          <span class="name-doc">{{template.type_name}}:</span>
          <p>{{template.name}}</p>
        </div>
        <div class="btn-row">
          <button class="btn w-xs" data-target="#modal-1" data-toggle="modal" ng-click="printDoc(template)">
            <span>Drucken</span>
            <i class="ion-printer"></i>
          </button>
        </div>
      </div>

    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">ABBRECHEN</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="chooseDocuments.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Druck-Template wählen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <h3 class="m-b-30">Vertragsvorlage für {{::countElements}} Elemente auswählen</h3>
      <div class="col-lg-12 text-left">
        <div class="form-group">
          <label>Zielvereinbarung</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_target_agreement_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in goal_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
        <div class="form-group">
          <label>Antrag</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_request_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in request_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
        <div class="form-group">
          <label>Fördervertrag</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_financing_agreement_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in funding_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
      </div>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="copyRequest.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Anfrage hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>

    <div class="panel-body text-center">
      <h3 class="m-b-30">Geben Sie die Jahr für die {{::countElements}} Elemente auswählen</h3>
      <ng-form name="copyRequest">
      <div class="col-lg-12 text-left">
        <div class="form-group">
          <label>Jahr</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
            <div class="input-group">
              <input required type="text" ng-change="search($select.search, 'year')" ng-click="dp_year_date_is_open = !dp_year_date_is_open" ng-model="year" uib-datepicker-popup="yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_year_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" name="year" >
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_year_date_is_open = !dp_year_date_is_open"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('year')}" class="hide">
              <label ng-show="copyRequest.year.$error.required" class="error">Jahr erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback" style="right: 38px;"></span>
            </span>
          </div>
        </div>
        <div class="form-group">
          <label>Kennziffer</label>
          <li class="list-group-item">{{::selectedElements}}</li>
        </div>
      </div>
      </ng-form>
    </div>

    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.$invalid || form.due_date < form.start_date">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="setDuration.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Laufzeit festlegen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <h3 class="m-b-30">Geben Sie die Zeitdauer für die {{::countElements}} Elemente ein</h3>
      <div class="form-group">
        <ng-form name="form">
          <div class="holder-datepicker text-right">
            <div class="col-lg-3 p-0">
              <label>Beginn</label>
            </div>
            <div class="col-lg-3 p-0">
              <div class="input-group">
                <input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
            <div class="col-lg-3 p-0">
              <label>Abgabedatum</label>
            </div>
            <div class="col-lg-3 p-0">
              <div class="input-group">
                <input type="text" ng-click="dp_end_fill_is_open = !dp_end_fill_is_open" ng-model="form.end_fill" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_end_fill_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>

          </div>
          <br>
          <div class="holder-datepicker text-right">
            <div class="col-lg-3 p-0">
              <label>Ende</label>
            </div>
            <div class="col-lg-3 p-0">
              <div class="input-group">
                <input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
          </div>
        </ng-form>
      </div>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.due_date < form.start_date">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="createRequest.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Antrag hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <div class="row text-left">
        <ng-form  name="createRequest">
        <div class="form-group col-lg-6">
          <label>Jahr</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
            <div class="input-group">
              <input required type="text" ng-change="search($select.search, 'year')" ng-click="dp_year_date_is_open = !dp_year_date_is_open" ng-model="year" uib-datepicker-popup="yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_year_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" name="year" >
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_year_date_is_open = !dp_year_date_is_open"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('year')}" class="hide">
              <label ng-show="createRequest.year.$error.required" class="error">Jahr erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback" style="right: 38px;"></span>
            </span>
          </div>
        </div>
        <div class="form-group col-lg-6">
          <label>Projekt</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('selected_project')}">
            <ui-select required class="type-document" ng-model="request.project_id" name="selected_project">
              <ui-select-match placeholder="Kennziffer eingegeben">{{$select.selected.code}}</ui-select-match>
              <ui-select-choices repeat="item.id as item in projects | filter: $select.search" refresh-delay="0" refresh="search($select.search)" >
                <span ng-bind-html="item.code | highlight: $select.search"></span>
              </ui-select-choices>
            </ui-select>
            <span ng-class="{hide: !fieldError('selected_project')}" class="hide">
              <label ng-show="createRequest.selected_project.$error.required" class="error">Projekt erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            </span>
          </div>
        </div>
        </ng-form >
      </div>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.$invalid || form.due_date < form.start_date">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="exportData.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix"> 
      <h3 class="m-0 pull-left">Daten exportieren</h3>
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div> 
    <div class="panel-body text-center">
      <ng-form name="sendToAccept">
        <h3 class="m-b-10 p-b-10">Daten aus Anträgen exportieren:</h3>
          <div class="checkbox p-b-10 clearfix custom-m-l-30">
            <label class="cr-styled pull-left" for="projectData"><input ng-change="checkCheckbox()" name="projectData" id="projectData" type="checkbox" ng-model="checkbox.projectData"><i class="fa"></i>Projektdaten</label>
          </div>
          <div class="checkbox p-b-10 clearfix custom-m-l-30">
            <label class="cr-styled pull-left" for="financeSingle"><input ng-change="checkCheckbox()" name="financeSingle" id="financeSingle" type="checkbox" ng-model="checkbox.financeSingle"><i class="fa"></i>Finanzplan(einzeln)</label>
          </div>
          <div class="checkbox p-b-10 clearfix custom-m-l-30">
            <label class="cr-styled pull-left" for="financeSumm"><input ng-change="checkCheckbox()" name="financeSumm" id="financeSumm" type="checkbox" ng-model="checkbox.financeSumm"><i class="fa"></i>Finanzplan(Summen)</label>
          </div>
      </ng-form>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button ng-disabled="count < 1 || count > 1" class="btn w-lg custom-btn" export-to-csv ng-click=""">Senden</button>
        </div>
      </div>
    </div>
  </div>
</script>
    <script type="text/ng-template" id="aside.html">
        <div class="modal-header">
            <h3 class="modal-title">ngAside</h3>
        </div>
        <div class="modal-body">
            <div ui-tree>
              <ol ui-tree-nodes="" ng-model="data" id="tree-root">
                <li ng-repeat="node in data" ui-tree-node ng-include="'nodes_renderer.html'"></li>
              </ol>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" ng-click="ok($event)">OK</button>
            <button class="btn btn-warning" ng-click="cancel($event)">Cancel</button>
        </div>
  </script>

  <script type="text/ng-template" id="nodes_renderer.html">
  <div  class="tree-node tree-node-content">
    <a class="btn folder-button btn-xs" ng-if="node.nodes && node.nodes.length > 0" data-nodrag ng-click="toggle(this)">
      <span class="glyphicon" ng-class="{
                                          'glyphicon glyphicon-folder-close': collapsed,
                                          'glyphicon glyphicon-folder-open': !collapsed
                                        }">
      </span>
      {{node.title}}
    </a>
    
  </div>
  <ol ui-tree-nodes="" ng-model="node.nodes" ng-class="{hidden: collapsed}">
    <li ng-if="node.id != undefined" ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer.html'">
    </li>
  </ol>
</script>

<script type="text/ng-template" id="showTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/document-template.php'); ?>
</script>