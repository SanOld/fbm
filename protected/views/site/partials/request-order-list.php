<div id="finance" class="tab-pane" ng-controller="RequestOrderListController">
  <div class="panel-group panel-group-joined m-0">
    <div class="panel panel-default">
      <ng-form name="financePlanForm">
      <div   class="panel-body p-t-0">
        <div class="row m-b-15 m-t-30">
          <div class="col-lg-6">
            <h3 class="panel-title title-custom">
              Изделия заказа:
            </h3>
          </div>
          <div class="col-lg-6 btn-row" hidden>
            <button class="btn w-xs pull-right" ng-click=""></button>
          </div>  
          <div class="col-lg-6 btn-row">
            <button class="btn w-xs pull-right" ng-click="request_users.push({})" >Добавить изделие</button>
          </div>
        </div>
        <div class="row m-b-30">
          <label class="col-lg-2 control-label">Группировка<span spi-hint text="_hint.fin_plan_employee_is_umlage.text"  title="_hint.fin_plan_employee_is_umlage.title"  class="has-hint"></span></label>
          <div class="btn-group btn-toggle col-lg-2 control-label wrap-hint">
            <button   ng-change="calculateAllEmployees(request_users)" ng-class="data.is_umlage == 1 ? 'active' : 'btn-default'" ng-model="data.is_umlage" uib-btn-radio="1" class="btn btn-sm">ДА</button>
            <button   ng-change="calculateAllEmployees(request_users)" ng-class="data.is_umlage != 1 ? 'active' : 'btn-default'" ng-model="data.is_umlage" uib-btn-radio="0" class="btn btn-sm">НЕТ</button>
          </div>
        </div>

        <div id="accordion-account" class="panel-group panel-group-joined row">
          <div class="panel panel-default row employee-row" data-name="{{emploee.user.name || 'ALLES ANZEIGEN'}}" ng-if="!emploee.is_deleted" ng-repeat="(key, emploee) in request_users">
            <div class="panel-heading">
              <button class="no-btn" title="Entfernen" ng-click="deleteEmployee($index)" ng-show="undelitetdCount(request_users) > 1 && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit">
                <i class="ion-close-round"></i>
              </button>
              <a  ng-class = "'collapsed'" href="#order{{$index}}" data-parent="#accordion-account" data-toggle="collapse">
                <strong>{{emploee.user.name || 'Кухня'}}
                </strong>
                <span class="sum">
                  <strong>Стоимость материалов</strong>
                  <span>€ {{8654 || 0| number:2}}</span>
                </span>
                <span class="sum">
                  <strong>Стоимсоть услуг</strong>
                  <span>€ {{5620 || 0| number:2}}</span>
                </span>
                <span class="sum total-sum">
                  <strong>Сумма</strong>
                  <span>€ {{14274 || 0| number:2}}</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse"  id="order{{$index}}">
              <div class="panel-body">

                <div class="row">
                  <div class="col-lg-4 p-r-0 custom-box-btn">
                    <div class="clearfix">
                      <label>Mitarbeiter/in<span spi-hint text="_hint.employee_id.text"  title="_hint.employee_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9 p-l-0 m-b-15" ng-class="{'wrap-line error': dublicate['employee'] || required['employee']}"> 
                        <input   placeholder="Vorname Nachname" ng-keyup="escapeEmployeeUser($event, $index)"
                               ng-keypress="submitToAddUserEmpl($event, emploee.new_user_name, $index)" 
                               ng-hide="!add_employee_user" class="form-control popup-input" type="text" ng-model="emploee.new_user_name"
                               ng-disabled="userLoading"
                               id="employee_user">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.user_id, 'Mitarbeiter' + '-' + key) && errorShow) }">

                              <ui-select required   on-select="employeeOnSelect($item, emploee)" class="type-document" ng-model="emploee.user_id">
                                <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_selected:0} | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                        </div>    
                        <div class="m-b-15"></div>
                        <dl class="custom-dl" ng-hide="emploee.user.sex == '3' || emploee.user.sex == '0' || !emploee.user_id ">
                          <dt>Anrede:</dt>
                          <dd ng-show = "emploee.user.sex == '1'">Herr</dd>
                          <dd ng-show = "emploee.user.sex == '2'">Frau</dd>
                        </dl>
                        <span ng-class="{hide: !(dublicate['employee'] || required['employee'])}" class="hide">
                          <label ng-show="required['employee']" class="error">Füllen Sie die Daten</label>
                          <label ng-show="dublicate['employee']" class="error">Dieser Name existiert bereits</label>
                        </span>                      
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_employee_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canEdit()">
                        <button class="btn m-t-2 add-user" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>             
                      <div class="col-lg-3 p-0" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUserEmpl($event, emploee.new_user_name, $index);">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <h4 class="col-lg-12 m-b-30 m-t-0">Vergleichsstellenbewertung entsprechend TV-L Berlin</h4>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltgruppe<span spi-hint text="_hint.fin_plan_employee_group_id.text"  title="_hint.fin_plan_employee_group_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-3">
                        <div  class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.group_id, 'Entgeltgruppe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltgruppe'+String($index)}}" class="type-document" ng-model="emploee.group_id" ng-init="emploee.group_id = emploee.group_id || '4'" ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in request_financial_group | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe<span spi-hint text="_hint.fin_plan_employee_remuneration_level_id.text"  title="_hint.fin_plan_employee_remuneration_level_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.remuneration_level_id, 'Entgeltstufe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltstufe'+$index}}" class="type-document" ng-model="emploee.remuneration_level_id" >
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in remuneration_level | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges<span spi-hint text="_hint.fin_plan_employee_other.text"  title="_hint.fin_plan_employee_other.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <input ng-change="maxLength(emploee,'other', 50);" maxlength="50"  class="form-control" ng-model="emploee.other" type="text" placeholder="max. 50 Zeichen">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="clearfix">
                  <h4>Ausgaben</h4>
                  <hr />
                  <div class="clearfix costs-box">
                    <div class="col-lg-4 form-horizontal">
                      <div class="form-group">
                        <label class="col-lg-6 control-label p-l-0">Kosten pro Monat (AN-Brutto)<span spi-hint text="_hint.fin_plan_employee_cost_per_month_brutto.text"  title="_hint.fin_plan_employee_cost_per_month_brutto.title"  class="has-hint"></span></label>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.cost_per_month_brutto, 'Kosten pro Monat (AN-Brutto)' + '-' + key) && errorShow) }">
                            <input  required name = "Kosten_pro_Monat" ng-change="calculateEmployee(emploee)" ng-model="emploee.cost_per_month_brutto" class="form-control" type="text" >
                        </div>                          
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt<span spi-hint text="_hint.fin_plan_employee_month_count.text"  title="_hint.fin_plan_employee_month_count.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.month_count, 'Geplante Monate im Projekt' + '-' + key) && errorShow) }">
                          <select  required  name = "{{'Geplante_Monate'+$index}}" class="form-control" ng-model="emploee.month_count" ng-change="calculateEmployee(emploee)" required>
                            <option value="12">12</option>
                            <option value="11">11</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                          </select>
                            <br>
                        </div> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche<span spi-hint text="_hint.fin_plan_employee_hours_per_week.text"  title="_hint.fin_plan_employee_hours_per_week.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.hours_per_week, 'Arbeitsstunden pro Woche' + '-' + key) && errorShow) }">
                            <input   required name = "Arbeitsstunden_pro_Woche" ng-change="numValidate(emploee,'hours_per_week', 4); maxValue(emploee,'hours_per_week', 40)" class="form-control" type="text" ng-model="emploee.hours_per_week" >
                        </div>                           
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Jahressonderzahlungen<span spi-hint text="_hint.fin_plan_employee_have_annual_bonus.text"  title="_hint.fin_plan_employee_have_annual_bonus.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_annual_bonus">
                            <div class="col-lg-2">
                            <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_annual_bonus == 1 && fieldsError2(emploee.annual_bonus, 'Jahressonderzahlungen') && errorShow) }">
                               <input  ng-change="calculateEmployee(emploee)" ng-required="(emploee.have_annual_bonus == 1 )" class="form-control" ng-model="emploee.annual_bonus" type="text" >
                            </div>                 
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Jahr</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (VWL)<span spi-hint text="_hint.fin_plan_employee_have_additional_provision_vwl.text"  title="_hint.fin_plan_employee_have_additional_provision_vwl.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input"  ng-show="emploee.have_additional_provision_vwl">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_additional_provision_vwl == 1 && fieldsError2(emploee.additional_provision_vwl, 'Zusatzversorgung (VWL)') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_additional_provision_vwl == 1" class="form-control" type="text" ng-model="emploee.additional_provision_vwl">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (betriebl. Altersversorgung)<span spi-hint text="_hint.fin_plan_employee_have_supplementary_pension.text"  title="_hint.fin_plan_employee_have_supplementary_pension.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_supplementary_pension">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_supplementary_pension == 1 && fieldsError2(emploee.supplementary_pension, 'Zusatzversorgung') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_supplementary_pension == 1" class="form-control" type="text" ng-model="emploee.supplementary_pension">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="panel panel-default row employee-row" data-name="{{emploee.user.name || 'ALLES ANZEIGEN'}}" ng-if="!emploee.is_deleted" ng-repeat="(key, emploee) in request_users">
            <div class="panel-heading">
              <button class="no-btn" title="Entfernen" ng-click="deleteEmployee($index)" ng-show="undelitetdCount(request_users) > 1 && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit">
                <i class="ion-close-round"></i>
              </button>
              <a  ng-class = "'collapsed'" href="#order2{{$index}}" data-parent="#accordion-account" data-toggle="collapse">
                <strong>{{emploee.user.name || 'Гардероб'}}
                </strong>
                <span class="sum">
                  <strong>Стоимость материалов</strong>
                  <span>€ {{2350 || 0| number:2}}</span>
                </span>
                <span class="sum">
                  <strong>Стоимсоть услуг</strong>
                  <span>€ {{880 || 0| number:2}}</span>
                </span>
                <span class="sum total-sum">
                  <strong>Сумма</strong>
                  <span>€ {{3230 || 0| number:2}}</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse"  id="order2{{$index}}">
              <div class="panel-body">

                <div class="row">
                  <div class="col-lg-4 p-r-0 custom-box-btn">
                    <div class="clearfix">
                      <label>Mitarbeiter/in<span spi-hint text="_hint.employee_id.text"  title="_hint.employee_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9 p-l-0 m-b-15" ng-class="{'wrap-line error': dublicate['employee'] || required['employee']}">
                        <input   placeholder="Vorname Nachname" ng-keyup="escapeEmployeeUser($event, $index)"
                               ng-keypress="submitToAddUserEmpl($event, emploee.new_user_name, $index)"
                               ng-hide="!add_employee_user" class="form-control popup-input" type="text" ng-model="emploee.new_user_name"
                               ng-disabled="userLoading"
                               id="employee_user">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.user_id, 'Mitarbeiter' + '-' + key) && errorShow) }">

                              <ui-select required   on-select="employeeOnSelect($item, emploee)" class="type-document" ng-model="emploee.user_id">
                                <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_selected:0} | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                        </div>
                        <div class="m-b-15"></div>
                        <dl class="custom-dl" ng-hide="emploee.user.sex == '3' || emploee.user.sex == '0' || !emploee.user_id ">
                          <dt>Anrede:</dt>
                          <dd ng-show = "emploee.user.sex == '1'">Herr</dd>
                          <dd ng-show = "emploee.user.sex == '2'">Frau</dd>
                        </dl>
                        <span ng-class="{hide: !(dublicate['employee'] || required['employee'])}" class="hide">
                          <label ng-show="required['employee']" class="error">Füllen Sie die Daten</label>
                          <label ng-show="dublicate['employee']" class="error">Dieser Name existiert bereits</label>
                        </span>
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_employee_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canEdit()">
                        <button class="btn m-t-2 add-user" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>
                      <div class="col-lg-3 p-0" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUserEmpl($event, emploee.new_user_name, $index);">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <h4 class="col-lg-12 m-b-30 m-t-0">Vergleichsstellenbewertung entsprechend TV-L Berlin</h4>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltgruppe<span spi-hint text="_hint.fin_plan_employee_group_id.text"  title="_hint.fin_plan_employee_group_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-3">
                        <div  class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.group_id, 'Entgeltgruppe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltgruppe'+String($index)}}" class="type-document" ng-model="emploee.group_id" ng-init="emploee.group_id = emploee.group_id || '4'" ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in request_financial_group | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe<span spi-hint text="_hint.fin_plan_employee_remuneration_level_id.text"  title="_hint.fin_plan_employee_remuneration_level_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.remuneration_level_id, 'Entgeltstufe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltstufe'+$index}}" class="type-document" ng-model="emploee.remuneration_level_id" >
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in remuneration_level | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges<span spi-hint text="_hint.fin_plan_employee_other.text"  title="_hint.fin_plan_employee_other.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <input ng-change="maxLength(emploee,'other', 50);" maxlength="50"  class="form-control" ng-model="emploee.other" type="text" placeholder="max. 50 Zeichen">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="clearfix">
                  <h4>Ausgaben</h4>
                  <hr />
                  <div class="clearfix costs-box">
                    <div class="col-lg-4 form-horizontal">
                      <div class="form-group">
                        <label class="col-lg-6 control-label p-l-0">Kosten pro Monat (AN-Brutto)<span spi-hint text="_hint.fin_plan_employee_cost_per_month_brutto.text"  title="_hint.fin_plan_employee_cost_per_month_brutto.title"  class="has-hint"></span></label>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.cost_per_month_brutto, 'Kosten pro Monat (AN-Brutto)' + '-' + key) && errorShow) }">
                            <input  required name = "Kosten_pro_Monat" ng-change="calculateEmployee(emploee)" ng-model="emploee.cost_per_month_brutto" class="form-control" type="text" >
                        </div>
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt<span spi-hint text="_hint.fin_plan_employee_month_count.text"  title="_hint.fin_plan_employee_month_count.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.month_count, 'Geplante Monate im Projekt' + '-' + key) && errorShow) }">
                          <select  required  name = "{{'Geplante_Monate'+$index}}" class="form-control" ng-model="emploee.month_count" ng-change="calculateEmployee(emploee)" required>
                            <option value="12">12</option>
                            <option value="11">11</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                          </select>
                            <br>
                        </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche<span spi-hint text="_hint.fin_plan_employee_hours_per_week.text"  title="_hint.fin_plan_employee_hours_per_week.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.hours_per_week, 'Arbeitsstunden pro Woche' + '-' + key) && errorShow) }">
                            <input   required name = "Arbeitsstunden_pro_Woche" ng-change="numValidate(emploee,'hours_per_week', 4); maxValue(emploee,'hours_per_week', 40)" class="form-control" type="text" ng-model="emploee.hours_per_week" >
                        </div>
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Jahressonderzahlungen<span spi-hint text="_hint.fin_plan_employee_have_annual_bonus.text"  title="_hint.fin_plan_employee_have_annual_bonus.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_annual_bonus">
                            <div class="col-lg-2">
                            <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_annual_bonus == 1 && fieldsError2(emploee.annual_bonus, 'Jahressonderzahlungen') && errorShow) }">
                               <input  ng-change="calculateEmployee(emploee)" ng-required="(emploee.have_annual_bonus == 1 )" class="form-control" ng-model="emploee.annual_bonus" type="text" >
                            </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Jahr</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (VWL)<span spi-hint text="_hint.fin_plan_employee_have_additional_provision_vwl.text"  title="_hint.fin_plan_employee_have_additional_provision_vwl.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input"  ng-show="emploee.have_additional_provision_vwl">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_additional_provision_vwl == 1 && fieldsError2(emploee.additional_provision_vwl, 'Zusatzversorgung (VWL)') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_additional_provision_vwl == 1" class="form-control" type="text" ng-model="emploee.additional_provision_vwl">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (betriebl. Altersversorgung)<span spi-hint text="_hint.fin_plan_employee_have_supplementary_pension.text"  title="_hint.fin_plan_employee_have_supplementary_pension.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_supplementary_pension">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_supplementary_pension == 1 && fieldsError2(emploee.supplementary_pension, 'Zusatzversorgung') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_supplementary_pension == 1" class="form-control" type="text" ng-model="emploee.supplementary_pension">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="panel panel-default row employee-row" data-name="{{emploee.user.name || 'ALLES ANZEIGEN'}}" ng-if="!emploee.is_deleted" ng-repeat="(key, emploee) in request_users">
            <div class="panel-heading">
              <button class="no-btn" title="Entfernen" ng-click="deleteEmployee($index)" ng-show="undelitetdCount(request_users) > 1 && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit">
                <i class="ion-close-round"></i>
              </button>
              <a  ng-class = "'collapsed'" href="#order3{{$index}}" data-parent="#accordion-account" data-toggle="collapse">
                <strong>{{emploee.user.name || 'Стол письменный'}}
                </strong>
                <span class="sum">
                  <strong>Стоимость материалов</strong>
                  <span>€ {{655 || 0| number:2}}</span>
                </span>
                <span class="sum">
                  <strong>Стоимсоть услуг</strong>
                  <span>€ {{125 || 0| number:2}}</span>
                </span>
                <span class="sum total-sum">
                  <strong>Сумма</strong>
                  <span>€ {{780 || 0| number:2}}</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse"  id="order3{{$index}}">
              <div class="panel-body">

                <div class="row">
                  <div class="col-lg-4 p-r-0 custom-box-btn">
                    <div class="clearfix">
                      <label>Mitarbeiter/in<span spi-hint text="_hint.employee_id.text"  title="_hint.employee_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9 p-l-0 m-b-15" ng-class="{'wrap-line error': dublicate['employee'] || required['employee']}">
                        <input   placeholder="Vorname Nachname" ng-keyup="escapeEmployeeUser($event, $index)"
                               ng-keypress="submitToAddUserEmpl($event, emploee.new_user_name, $index)"
                               ng-hide="!add_employee_user" class="form-control popup-input" type="text" ng-model="emploee.new_user_name"
                               ng-disabled="userLoading"
                               id="employee_user">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.user_id, 'Mitarbeiter' + '-' + key) && errorShow) }">

                              <ui-select required   on-select="employeeOnSelect($item, emploee)" class="type-document" ng-model="emploee.user_id">
                                <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_selected:0} | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                        </div>
                        <div class="m-b-15"></div>
                        <dl class="custom-dl" ng-hide="emploee.user.sex == '3' || emploee.user.sex == '0' || !emploee.user_id ">
                          <dt>Anrede:</dt>
                          <dd ng-show = "emploee.user.sex == '1'">Herr</dd>
                          <dd ng-show = "emploee.user.sex == '2'">Frau</dd>
                        </dl>
                        <span ng-class="{hide: !(dublicate['employee'] || required['employee'])}" class="hide">
                          <label ng-show="required['employee']" class="error">Füllen Sie die Daten</label>
                          <label ng-show="dublicate['employee']" class="error">Dieser Name existiert bereits</label>
                        </span>
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_employee_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canEdit()">
                        <button class="btn m-t-2 add-user" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>
                      <div class="col-lg-3 p-0" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUserEmpl($event, emploee.new_user_name, $index);">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewEmployeeUser($index)">&nbsp;</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <h4 class="col-lg-12 m-b-30 m-t-0">Vergleichsstellenbewertung entsprechend TV-L Berlin</h4>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltgruppe<span spi-hint text="_hint.fin_plan_employee_group_id.text"  title="_hint.fin_plan_employee_group_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-3">
                        <div  class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.group_id, 'Entgeltgruppe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltgruppe'+String($index)}}" class="type-document" ng-model="emploee.group_id" ng-init="emploee.group_id = emploee.group_id || '4'" ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in request_financial_group | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe<span spi-hint text="_hint.fin_plan_employee_remuneration_level_id.text"  title="_hint.fin_plan_employee_remuneration_level_id.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.remuneration_level_id, 'Entgeltstufe' + '-' + key) && errorShow) }">
                              <ui-select required name = "{{'Entgeltstufe'+$index}}" class="type-document" ng-model="emploee.remuneration_level_id" >
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in remuneration_level | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                              <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges<span spi-hint text="_hint.fin_plan_employee_other.text"  title="_hint.fin_plan_employee_other.title"  class="has-hint"></span></label>
                      <div class="col-lg-9">
                        <input ng-change="maxLength(emploee,'other', 50);" maxlength="50"  class="form-control" ng-model="emploee.other" type="text" placeholder="max. 50 Zeichen">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="clearfix">
                  <h4>Ausgaben</h4>
                  <hr />
                  <div class="clearfix costs-box">
                    <div class="col-lg-4 form-horizontal">
                      <div class="form-group">
                        <label class="col-lg-6 control-label p-l-0">Kosten pro Monat (AN-Brutto)<span spi-hint text="_hint.fin_plan_employee_cost_per_month_brutto.text"  title="_hint.fin_plan_employee_cost_per_month_brutto.title"  class="has-hint"></span></label>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.cost_per_month_brutto, 'Kosten pro Monat (AN-Brutto)' + '-' + key) && errorShow) }">
                            <input  required name = "Kosten_pro_Monat" ng-change="calculateEmployee(emploee)" ng-model="emploee.cost_per_month_brutto" class="form-control" type="text" >
                        </div>
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt<span spi-hint text="_hint.fin_plan_employee_month_count.text"  title="_hint.fin_plan_employee_month_count.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.month_count, 'Geplante Monate im Projekt' + '-' + key) && errorShow) }">
                          <select  required  name = "{{'Geplante_Monate'+$index}}" class="form-control" ng-model="emploee.month_count" ng-change="calculateEmployee(emploee)" required>
                            <option value="12">12</option>
                            <option value="11">11</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                          </select>
                            <br>
                        </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche<span spi-hint text="_hint.fin_plan_employee_hours_per_week.text"  title="_hint.fin_plan_employee_hours_per_week.title"  class="has-hint"></span></label>
                        <div class="col-lg-4">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(emploee.hours_per_week, 'Arbeitsstunden pro Woche' + '-' + key) && errorShow) }">
                            <input   required name = "Arbeitsstunden_pro_Woche" ng-change="numValidate(emploee,'hours_per_week', 4); maxValue(emploee,'hours_per_week', 40)" class="form-control" type="text" ng-model="emploee.hours_per_week" >
                        </div>
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Jahressonderzahlungen<span spi-hint text="_hint.fin_plan_employee_have_annual_bonus.text"  title="_hint.fin_plan_employee_have_annual_bonus.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_annual_bonus">
                            <div class="col-lg-2">
                            <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_annual_bonus == 1 && fieldsError2(emploee.annual_bonus, 'Jahressonderzahlungen') && errorShow) }">
                               <input  ng-change="calculateEmployee(emploee)" ng-required="(emploee.have_annual_bonus == 1 )" class="form-control" ng-model="emploee.annual_bonus" type="text" >
                            </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Jahr</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (VWL)<span spi-hint text="_hint.fin_plan_employee_have_additional_provision_vwl.text"  title="_hint.fin_plan_employee_have_additional_provision_vwl.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input"  ng-show="emploee.have_additional_provision_vwl">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_additional_provision_vwl == 1 && fieldsError2(emploee.additional_provision_vwl, 'Zusatzversorgung (VWL)') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_additional_provision_vwl == 1" class="form-control" type="text" ng-model="emploee.additional_provision_vwl">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (betriebl. Altersversorgung)<span spi-hint text="_hint.fin_plan_employee_have_supplementary_pension.text"  title="_hint.fin_plan_employee_have_supplementary_pension.title"  class="has-hint"></span></label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button   ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_supplementary_pension">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_supplementary_pension == 1 && fieldsError2(emploee.supplementary_pension, 'Zusatzversorgung') && errorShow) }">
                                <input  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_supplementary_pension == 1" class="form-control" type="text" ng-model="emploee.supplementary_pension">
                              </div>
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="m-b-30">
          <div class="row m-b-15">
            <h3 class="panel-title title-custom col-lg-6">
              Дополнительные услуги
            </h3>
            <div class="col-lg-6 btn-row">
              <button class="btn w-xs pull-right" ng-click="prof_associations.push({})">Добавить услугу</button>
            </div>
          </div>
          <hr />
          <!--<ng-form name="financePlanFormGroup1" disable-all="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept)">-->
          <div class="row form-horizontal m-b-15" ng-repeat="(key, association) in prof_associations" ng-if="!association.is_deleted">
            <label class="col-lg-1 control-label">
              Наименование<span spi-hint text="_hint.fin_plan_association_name.text"  title="_hint.fin_plan_association_name.title"  class="has-hint"></span>
            </label>
            <div class="col-lg-7">
              <div class="wrap-hint" ng-class="{'wrap-line error': (prof_associations.length > 1 && fieldsError2(association.name, 'Berufsgenossenschaftsbeiträge-Name' + '-' + key) && errorShow) }">
                <input name = "first" class="form-control" type="text"
                       ng-model="association.name"
                       >
              </div>
            </div>
            <label class="col-lg-1 p-r-0 control-label">
              Стоимость<span spi-hint text="_hint.fin_plan_association_sum.text"  title="_hint.fin_plan_association_sum.title"  class="has-hint"></span>
            </label>
            <div class="col-lg-2">
              <div class="wrap-hint" ng-class="{'wrap-line error': (prof_associations.length > 1 && fieldsError2(association.sum,  'Berufsgenossenschaftsbeiträge-Beitrag' + '-' + key) && errorShow) }">
                <input class="form-control" type="text"
                  
                       ng-init = "association.sum = (association.sum || '0,00'); numValidate2(association,'sum');"
                       ng-change="numValidate(association,'sum') ; updateResultCost();"
                       ng-model="association.sum" >
              </div>
            </div>
            <div class="col-lg-1 p-0 custom-col-1 m-t-5">
              <span class="symbol">€</span>
            </div>
            <div class="col-lg-1 custom-col-1 m-t-5" ng-show="undelitetdCount(prof_associations) > 1 && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit">
              <button ng-click="deleteProfAssociation($index)" class="no-btn" title="Entfernen" >
                <i class="ion-close-round"></i>
              </button>
            </div>
          </div>
          <!--</ng-form>-->
        </div>

        <div class="row" ng-if="data.status_finance != 'accepted' && canAcceptEarly(data.status_finance)">
          <div class="col-lg-10">
              <span ng-if="canAccept && data.status_finance != 'rejected'">
                <h4 class="m-t-0">Примечание</h4>
                <textarea  placeholder="Введите текст" ng-model="data.comment" class="form-control comments"></textarea>
              </span>
          </div>
          <div class="col-lg-2">
            <div class="m-t-30 text-right pull-right">
              <button  class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm('accepted')">ПРИНЯТЬ</button>
              <button  ng-class="{disabled: !data.comment}" ng-click="submitForm('rejected')" class="btn w-lg btn-lg btn-danger">ОТКЛОНИТЬ</button>
            </div>
            <div class="text-right pull-right" ng-if="canFormEdit && !canAccept && data.status_finance != 'in_progress' && data.status_finance != 'accepted' && canEdit()">
              <h4 class="m-t-0"></h4>
              <button class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm('in_progress')" title="Antragsteil zur Prüfung übermitteln">НА ПРОВЕРКУ</button>
            </div>
          </div>
        </div>
      </div>
      </ng-form>
    </div>
  </div>
</div>
