<div id="project" class="tab-pane active" ng-controller="RequestProjectDataController">
  <ng-form name="projectData" disable-all="{{!canEdit()}}">
    <div class="panel-group panel-group-joined m-0">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
              <div class="col-lg-4">
                <div class="sum clearfix">
                  <strong>Номер заказа</strong>
                  <div class="col-lg-10 p-l-0 m-t-10">
                      <input required name = "" type="text" class="form-control" >
                  </div>
                </div>
              </div>
<!--            <div class="col-lg-4">
              <div class="heading-date">
                <strong>Дата окончания текущего этапа:</strong>
                <div class="holder-head-date custom-dl m-t-10">
                  <i class="fa fa-calendar"></i>
                  <div class="wrap-data">
                    <div class="m-t-10">
                      <span>Покраска:</span>
                      <em ng-if="request.end_fill">{{getDate(request.end_fill)| date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.end_fill">-</em>
                    </div>
                  </div>
                  <div class="btn-row" ng-show="userCan('dates')">
                    <button class="btn m-t-5" ng-click="setEndFillDate()">Выбор даты</button>
                  </div>
                </div>
              </div>
            </div>-->
            <div class="col-lg-4 col-lg-offset-4">
              <div class="heading-date">
                <strong>Дата начала/окончания:</strong>
                <div class="holder-head-date custom-dl  m-t-10">
                  <i class="fa fa-calendar"></i>
                  <div class="wrap-data">
                    <div>
                      <span>Прием:</span>
                      
                      <em ng-if="request.start_date">{{getDate(request.start_date) | date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.start_date">-</em>
                    </div>
                    <div>
                      <span>Сдача:</span>
                      <em ng-if="request.due_date">{{getDate(request.due_date)| date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.due_date">-</em>
                    </div>
                  </div>
                  <div class="btn-row" ng-show="userCan('dates')">
                    <button class="btn m-t-5" ng-click="setBulkDuration()">Выбор даты</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="panel-body">
            <hr>
            <div class="form-group clearfix school-row">
              <div class="col-lg-3">
                <div class="sum  clearfix">
                  <strong>Стоимость</strong>
                  <div class="col-lg-10 p-l-0 m-t-10">
                      <input required name = "{{('Stellenanteil'+$index)}}" type="text" class="form-control"   value = "€ {{18284 | number:2}}">
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <span class="sum calendar-ico clearfix">
                  <strong>Доп.затраты</strong>
                  <div class="col-lg-10 p-l-0 m-t-10">
                      <input type="text" class="form-control"  value = "€ {{520 | number:2}}">
                  </div>
                </span>
              </div>
              <div class="col-lg-3 ">
                <span class="sum clearfix">
                  <strong>Оплачено</strong>
                  <div class="col-lg-10 p-l-0 m-t-10">
                      <input type="text" class="form-control"  value = "€ {{10500 | number:2}}">
                  </div>
                </span>
              </div>
              <div class="col-lg-3">
                <span class="sum clearfix">
                  <strong>Задолженность</strong>
                  <!--<span>€ 11500,00</span>-->
                  <div class="col-lg-10 p-l-0 m-t-10">
                      <input type="text" class="form-control"  value = "€ {{8304 | number:2}}">
                  </div>
                </span>
              </div>
            </div>

            <hr>


          <div class="row">


                  <div class="col-lg-6 custom-box-btn">
                    <h4 class="panel-title m-b-10">
                      <label>
                        Клиент
                      </label>
                    </h4>
                    <div class="clearfix">
                      <div class="col-lg-9 p-l-0 m-b-15"  ng-class="{'wrap-line error': dublicate || required}" >
                      <input placeholder="Имя Фамилия" ng-keyup="escape($event)" ng-disabled="userLoading"
                             ng-keypress="submitToAddUser($event, new_project_user)" ng-hide="!add_project_user" class="form-control popup-input" type="text"
                             ng-model="new_project_user" ng-required="add_project_user" id="project_user">
                      <ui-select on-select="onSelectCallback($item, $model, 2)" class="type-document" ng-model="request.concept_user_id" ng-disabled="!userCan('users')">
                        <ui-select-match allow-clear="true" placeholder="Пожалуйста, выберите">{{$select.selected.name}}</ui-select-match>
                        <ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
                          <span ng-bind-html="item.name | highlight: $select.search"></span>
                        </ui-select-choices>
                      </ui-select>
                      <span ng-class="{hide: !(dublicate || required)}" class="hide">
                        <label ng-show="required" class="error">Füllen Sie die Daten</label>
                        <label ng-show="dublicate" class="error">Dieser Name existiert bereits</label>
                      </span>
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_project_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()" >
                        <button class="btn m-t-2 add-user" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>
                      <div class="col-lg-3 p-0" ng-show="add_project_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUser($event, new_project_user)">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>
                    </div>
                    <dl class="custom-dl" ng-show="selectConceptResult && !add_project_user">
                      <ng-show ng-show="selectConceptResult.phone">
                        <dt>Telefon:</dt>
                        <dd>{{selectConceptResult.phone}}</dd>
                      </ng-show>
                      <ng-show ng-show="selectConceptResult.email">
                        <dt>E-Mail:</dt>
                        <dd><a class="visible-lg-block" href="mailto:{{selectConceptResult.email}}">{{selectConceptResult.email}}</a></dd>
                      </ng-show>
                    </dl>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-lg-6 custom-box-btn">
                    <h4 class="panel-title m-b-10">
                      <label>
                        Менеджер
                      </label>
                    </h4>
                    <div class="clearfix">
                      <div class="col-lg-9 p-l-0 m-b-15"  ng-class="{'wrap-line error': dublicate || required}" >
                      <input placeholder="Имя Фамилия" ng-keyup="escape($event)" ng-disabled="userLoading"
                             ng-keypress="submitToAddUser($event, new_project_user)" ng-hide="!add_project_user" class="form-control popup-input" type="text"
                             ng-model="new_project_user" ng-required="add_project_user" id="project_user">
                      <ui-select on-select="onSelectCallback($item, $model, 2)" class="type-document" ng-model="request.concept_user_id" ng-disabled="!userCan('users')">
                        <ui-select-match allow-clear="true" placeholder="Пожалуйста, выберите">{{$select.selected.name}}</ui-select-match>
                        <ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
                          <span ng-bind-html="item.name | highlight: $select.search"></span>
                        </ui-select-choices>
                      </ui-select>
                      <span ng-class="{hide: !(dublicate || required)}" class="hide">
                        <label ng-show="required" class="error">Füllen Sie die Daten</label>
                        <label ng-show="dublicate" class="error">Dieser Name existiert bereits</label>
                      </span>
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_project_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()" >
                        <button class="btn m-t-2 add-user" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>
                      <div class="col-lg-3 p-0" ng-show="add_project_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUser($event, new_project_user)">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>
                    </div>
                    <dl class="custom-dl" ng-show="selectConceptResult && !add_project_user">
                      <ng-show ng-show="selectConceptResult.phone">
                        <dt>Telefon:</dt>
                        <dd>{{selectConceptResult.phone}}</dd>
                      </ng-show>
                      <ng-show ng-show="selectConceptResult.email">
                        <dt>E-Mail:</dt>
                        <dd><a class="visible-lg-block" href="mailto:{{selectConceptResult.email}}">{{selectConceptResult.email}}</a></dd>
                      </ng-show>
                    </dl>
                  </div>
          </div>
        </div>
        <hr/>
        <div class="row">
          <div class="col-lg-12">
            <h4 class="m-t-0">Дополнительная информация</h4>
            <textarea ng-disabled="!userCan('additional_info')" placeholder="Введите текст" ng-model="request.additional_info" class="form-control"></textarea>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-lg-4 form-horizontal">
            <h4>Шаблоны документов</h4>
            <div class="form-group">
              <label class="col-lg-4 control-label">Договор:</label>
              <div class="col-lg-8">
                <ui-select ng-change="" class="type-document" ng-model="request.doc_target_agreement_id" ng-disabled="!userCan('templates')">
                  <ui-select-match allow-clear="true" placeholder="Шаблон не выбран">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'goal_agreement'} | orderBy: 'name'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>


            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Рассчет:</label>
              <div class="col-lg-8">
                <ui-select ng-change="" class="type-document" ng-model="request.doc_request_id" ng-disabled="!userCan('templates')">
                  <ui-select-match allow-clear="true" placeholder="Шаблон не выбран">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'request_agreement'} | orderBy: 'name'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Спецификация:</label>
              <div class="col-lg-8">
                <ui-select ng-change="" class="type-document" ng-model="request.doc_financing_agreement_id" ng-disabled="!userCan('templates')">
                  <ui-select-match allow-clear="true" placeholder="Шаблон не выбран">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'funding_agreement'} | orderBy: 'name'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <h4>Примечание</h4>
            <textarea ng-disabled="!userCan('senat_additional_info')" class="form-control custom-height-textarea" placeholder="Введите текст" ng-model="request.senat_additional_info" class="form-control"></textarea>
          </div>
        </div>
      </div>
    </div>
  </ng-form>
</div>
