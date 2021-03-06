<div id="finance" class="tab-pane" ng-controller="RequestFinancePlanController">
  <div class="panel-group panel-group-joined m-0">
    <div class="panel panel-default">
      <div ng-if="data.status_finance != 'unfinished'" class="alert" ng-class="{'alert-danger': data.status_finance == 'rejected', 'alert-success': data.status_finance == 'accepted', 'alert-warning': data.status_finance == 'in_progress'}">
        <div ng-switch="data.status_finance">
          <strong ng-switch-when="rejected">Anmerkung der Programmagentur</strong>
          <strong ng-switch-when="accepted">Geprüft</strong>
          <strong ng-switch-when="in_progress">Zur Prüfung übermittelt</strong>
        </div>
        <div ng-if="data.finance_comment && (data.status_finance == 'rejected' || data.status_finance == 'in_progress')" ng-bind="data.finance_comment"></div>
      </div>
      <div class="clearfix">
        <h2 class="panel-title title-custom pull-left">
          Finanzplan
        </h2>
      </div>
      <hr />
      <ng-form name="financePlanForm">
      <div   class="panel-body p-t-0">
        <div class="row">
          <div class="col-lg-4 p-r-0 custom-box-btn">
            <div class="clearfix">
              <label>Ansprechperson für Rückfragen zum Finanzplan<span spi-hint text="_hint.fin_plan_finance_user_id.text"  title="_hint.fin_plan_finance_user_id.title"  class="has-hint"></span></label>
              <div class="col-lg-9 p-l-0 m-b-15" ng-class="{'wrap-line error': dublicate['finance'] || required['finance']}">  
                  <input   placeholder="Vorname Nachname" ng-keyup="escapeFinanceUser($event)" ng-keypress="submitToAddUser($event, new_fina_user)"
                       ng-hide="!add_finance_user" class="form-control popup-input" type="text" ng-model="new_fina_user"
                       ng-disabled="userLoading" id="finance_user">                 
          
                <div  class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(data.finance_user_id, 'Ansprechperson') && errorShow) }">
                      <ui-select  required name = "Ansprechperson" on-select="onSelectCallback($item, $model, 3)" class="type-document" ng-model="data.finance_user_id"
                       ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
                        <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                        <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_finansist:1} | orderBy: 'name'">
                          <span ng-bind-html="item.name | highlight: $select.search"></span>
                        </ui-select-choices>
                      </ui-select>
                      <br>
                </div>


                <span ng-class="{hide: !(dublicate['finance'] || required['finance'])}" class="hide">
                  <label ng-show="required['finance']" class="error">Füllen Sie die Daten</label>
                  <label ng-show="dublicate['finance']" class="error">Dieser Name existiert bereits</label>
                </span>
                </div>
                <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_finance_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canEdit()">
                  <button class="btn m-t-2 add-user" ng-click="addNewFinanceUser()">&nbsp;</button>
                </div>             
                <div class="col-lg-3 p-0" ng-show="add_finance_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canEdit()">
                  <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUser($event, new_fina_user);">&nbsp;</button>
                  <button class="btn m-t-2 hide-btn" ng-click="addNewFinanceUser()">&nbsp;</button>
                </div>             
            </div>
            <dl class="custom-dl" ng-show="selectFinanceResult && !add_finance_user">
<!--              <ng-show ng-show="selectFinanceResult.function">
                <dt>Funktion:</dt>
                <dd>{{selectFinanceResult.function}}</dd>
              </ng-show>
              <ng-show ng-show="selectFinanceResult.gender">
                <dt>Anrede:</dt>
                <dd>{{selectFinanceResult.gender}}</dd>
              </ng-show>-->
              <ng-show ng-show="selectFinanceResult.phone">
                <dt>Telefon:</dt>
                <dd>{{selectFinanceResult.phone}}</dd>
              </ng-show>
              <ng-show ng-show="selectFinanceResult.email">
                <dt>E-Mail:</dt>
                <dd><a class="visible-lg-block" href="mailto:{{selectFinanceResult.email}}">{{selectFinanceResult.email}}</a></dd>
              </ng-show>
            </dl>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label>Bankverbindung<span spi-hint text="_hint.fin_plan_bank_details_id.text"  title="_hint.fin_plan_bank_details_id.title"  class="has-hint"></span></label>
                <div class="wrap-hint" ng-class="{'wrap-line error': (fieldsError2(data.bank_details_id, 'Bankverbindung') && errorShow) }">
                  <ui-select required name = "Bankverbindung" class="type-document" on-select="updateIBAN($item)" ng-model="data.bank_details_id"  ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
                    <ui-select-match allow-clear="true" placeholder="Alles anzeigen">IBAN: {{$select.selected.iban}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in bank_details | filter: $select.search | orderBy: 'iban'">
                      <span ng-bind-html="item.iban | highlight: $select.search"></span>
                    </ui-select-choices>
                  </ui-select>
                  <br>
                </div>
            </div>
            <dl class="custom-dl" ng-if="IBAN.contact_person || IBAN.bank_name || IBAN.description">
              <dt ng-show="IBAN.contact_person">Kontoinhaber: </dt>
              <dd ng-show="IBAN.contact_person" class="dd-margin">{{IBAN.contact_person}}</dd>
              <dt ng-show="user.type == 'a' || user.type == 'p'">Kreditor:</dt>
              <dd ng-show="user.type == 'a' || user.type == 'p'" class="dd-margin">{{IBAN.bank_name ? IBAN.bank_name : '-'}}</dd>
              <dt ng-show="IBAN.description">Beschreibung:</dt>
              <dd ng-show="IBAN.description" class="dd-margin">{{IBAN.description}}</dd>
            </dl>
          </div>
          <div class="col-lg-4">
            <div class="clearfix box-recalculate">
              <div class="col-lg-12 text-center form-custom-box ">
                <div class="sum total-sum">
                  <strong>Beantragte Fördermittel</strong>
                  <span>€ {{total_cost||0| number:2}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-lg-5 calculate m-b-30 p-r-0 pull-right">
<label class="col-lg-8 control-label text-right ">Recalculation</label>
<div class="btn-group btn-toggle col-lg-4 control-label">
<button class="btn btn-sm btn-default">JA</button>
<button class="btn btn-sm active">NEIN</button>
</div>
</div> -->
        </div>
        <div class="row m-b-15 m-t-30">
          <div class="col-lg-6">
            <h3 class="panel-title title-custom">
              Ausgaben: Personalkosten
            </h3>
          </div>
          <div class="col-lg-6 btn-row" hidden>
            <button class="btn w-xs pull-right" ng-click=""></button>
          </div>  
          <div class="col-lg-6 btn-row">
            <button class="btn w-xs pull-right" ng-click="request_users.push({})" 
                    ng-show="data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit && canEdit()">Mitarbeiter/in hinzufügen</button>
          </div>
        </div>
        <div class="row m-b-30">
          <label class="col-lg-2 control-label">Umlage 1<span spi-hint text="_hint.fin_plan_employee_is_umlage.text"  title="_hint.fin_plan_employee_is_umlage.title"  class="has-hint"></span></label>
          <div class="btn-group btn-toggle col-lg-2 control-label wrap-hint">
            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateAllEmployees(request_users)" ng-class="data.is_umlage == 1 ? 'active' : 'btn-default'" ng-model="data.is_umlage" uib-btn-radio="1" class="btn btn-sm">JA</button>
            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateAllEmployees(request_users)" ng-class="data.is_umlage != 1 ? 'active' : 'btn-default'" ng-model="data.is_umlage" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
          </div>
        </div>

        <div id="accordion-account" class="panel-group panel-group-joined row">
          <div class="panel panel-default row employee-row" data-name="{{emploee.user.name || 'ALLES ANZEIGEN'}}" ng-if="!emploee.is_deleted" ng-repeat="(key, emploee) in request_users">
            <div class="panel-heading">
              <button class="no-btn" title="Entfernen" ng-click="deleteEmployee($index)" ng-show="undelitetdCount(request_users) > 1 && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit">
                <i class="ion-close-round"></i>
              </button>
              <a  ng-class = "{'collapsed': collapsingUser != $index}" href="#account{{$index}}" data-parent="#accordion-account" data-toggle="collapse">
                <strong>{{emploee.user.name || 'ALLES ANZEIGEN'}}
                </strong>
                <span class="sum">
                  <strong>Summe AN-Brutto mit Zusatzversorgung</strong>
                  <span>€ {{emploee.brutto || 0| number:2}}</span>
                </span>
                <span class="sum">
                  <strong>Summe AG-Anteil nur SV und Umlagen</strong>
                  <span>€ {{emploee.addCost || 0| number:2}}</span>
                </span>
                <span class="sum total-sum">
                  <strong>Anrechenbare Personalkosten</strong>
                  <span>€ {{emploee.fullCost || 0| number:2}}</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse" ng-class = "{'in': collapsingUser == $index}" id="account{{$index}}">
              <div class="panel-body">
<!--                <div class="row m-b-30">
                  <label class="col-lg-2 control-label">Umlage 1<span spi-hint text="_hint.fin_plan_employee_is_umlage.text"  title="_hint.fin_plan_employee_is_umlage.title"  class="has-hint"></span></label>
                  <div class="btn-group btn-toggle col-lg-2 control-label wrap-hint">
                    <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit" ng-change="calculateEmployee(emploee)" ng-class="emploee.is_umlage == 1 ? 'active' : 'btn-default'" ng-model="emploee.is_umlage" uib-btn-radio="1" class="btn btn-sm">JA</button>
                    <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit" ng-change="calculateEmployee(emploee)" ng-class="emploee.is_umlage != 1 ? 'active' : 'btn-default'" ng-model="emploee.is_umlage" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                  </div>
                </div>-->
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

                              <ui-select required   on-select="employeeOnSelect($item, emploee)" class="type-document" ng-model="emploee.user_id"
                                         ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
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
                      <div class="col-lg-3 p-0" ng-show="add_employee_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()">
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
                              <ui-select required name = "{{'Entgeltstufe'+$index}}" class="type-document" ng-model="emploee.remuneration_level_id"  ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()">
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
                        <input ng-change="maxLength(emploee,'other', 50);" maxlength="50" ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit" class="form-control" ng-model="emploee.other" type="text" placeholder="max. 50 Zeichen">
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
                            <input ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()" required name = "Kosten_pro_Monat" ng-change="calculateEmployee(emploee)" ng-model="emploee.cost_per_month_brutto" class="form-control" type="text" >
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
                          <select ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()" required  name = "{{'Geplante_Monate'+$index}}" class="form-control" ng-model="emploee.month_count" ng-change="calculateEmployee(emploee)" required>
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
                            <input ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  required name = "Arbeitsstunden_pro_Woche" ng-change="numValidate(emploee,'hours_per_week', 4); maxValue(emploee,'hours_per_week', 40)" class="form-control" type="text" ng-model="emploee.hours_per_week" >
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
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_annual_bonus">
                            <div class="col-lg-2">
                            <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_annual_bonus == 1 && fieldsError2(emploee.annual_bonus, 'Jahressonderzahlungen') && errorShow) }">
                               <input ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-required="(emploee.have_annual_bonus == 1 )" class="form-control" ng-model="emploee.annual_bonus" type="text" >
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
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input"  ng-show="emploee.have_additional_provision_vwl">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_additional_provision_vwl == 1 && fieldsError2(emploee.additional_provision_vwl, 'Zusatzversorgung (VWL)') && errorShow) }">
                                <input ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_additional_provision_vwl == 1" class="form-control" type="text" ng-model="emploee.additional_provision_vwl">
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
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_supplementary_pension">
                            <div class="col-lg-2">
                              <div class="wrap-hint" ng-class="{'wrap-line error': (emploee.have_supplementary_pension == 1 && fieldsError2(emploee.supplementary_pension, 'Zusatzversorgung') && errorShow) }">
                                <input ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"  ng-change="calculateEmployee(emploee)" ng-required="emploee.have_supplementary_pension == 1" class="form-control" type="text" ng-model="emploee.supplementary_pension">
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
          <h3 class="panel-title title-custom m-b-15">
            Ausgaben: Sachkosten
          </h3>
          <div ng-repeat="(key, school) in financeSchools">
            <h4 ng-if="school.school_name">{{school.school_name}} ({{school.school_number}})</h4>
            <hr>
            <div class="form-group clearfix school-row">
              <div class="col-lg-2 custom-school-row">
                <div class="sum rate-ico clearfix">
                  <strong>Stellenanteil</strong>
                  <div class="col-lg-12 p-l-0 m-t-10">
                    <div class="has-hint has-hint2">
                      <span spi-hint text="_hint.fin_plan_school_rate.text"  title="_hint.fin_plan_school_rate.title" ></span>
                    </div>
<!--                    <div class="wrap-hint">
                      <input required name = "Stellenanteil" type="text" class="form-control" ng-init = " numValidate2(school,'rate', 3)" ng-change=" numValidate(school,'rate', 3); updateTrainingCost(school)" ng-model="school.rate" ng-disabled="!canAccept">
                    </div>-->
                    <div class="wrap-hint" ng-class="{'wrap-line error': (( canAccept && fieldsError2(school.rate, 'Stellenanteil' + '-' + key)  && errorShow) || errorArray.indexOf('Stellenanteil'+ '-' + key) != -1) }">
                      <input required name = "{{('Stellenanteil'+$index)}}" type="text" class="form-control" ng-init = " numValidate2(school,'rate', 3)" ng-change=" numValidate(school,'rate', 3); updateTrainingCost(school)" ng-model="school.rate" 
                             ng-disabled="data.status_finance == 'accepted' || !canAccept || !canEdit()">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-lg-offset-1">
                <span class="sum calendar-ico clearfix">
                  <strong>Monat</strong>
                  <div class="col-lg-12 p-l-0 m-t-10">
                    <div class="has-hint has-hint2">
                      <span spi-hint text="_hint.fin_plan_school_month_count.text"  title="_hint.fin_plan_school_month_count.title" ></span>
                    </div>
                    <div class="wrap-hint" ng-class="{'wrap-line error': ((canAccept && fieldsError2(school.month_count, 'Monat' + '-' + key))  && errorShow ) }">
                      <input type="text" class="form-control" ng-init = "numValidate2(school,'month_count');" ng-change="numValidate(school,'month_count');" ng-model="school.month_count"
                             ng-disabled="data.status_finance == 'accepted' || !canAccept || !canEdit()">
                    </div>
                  </div>
                </span>
              </div>
              <div class="col-lg-3 col-lg-offset-1 custom-school-row">
                <span class="sum clearfix">
                  <strong>Fortbildungskosten</strong>
                  <div class="col-lg-9 p-l-0 m-t-10">
                    <div class="has-hint has-hint2">
                      <span spi-hint text="_hint.fin_plan_school_traning_cost.text"  title="_hint.fin_plan_school_traning_cost.title" ></span>
                    </div>
                    <div class="wrap-hint" ng-class="{'wrap-line error': ((canAccept && fieldsError2(school.training_cost, 'Fortbildungskosten' + '-' + key))  && errorShow) }">
                      <input type="text" class="form-control" ng-init = "numValidate2(school,'training_cost');"  ng-change="numValidate(school,'training_cost');updateResultCost();" ng-model="school.training_cost" 
                             ng-disabled="data.status_finance == 'accepted' || !canAccept || !canEdit() || school.rate*1 > 1 && school.rate*1 < 0.5">
                    </div>
                  </div>
                </span>
              </div>
              <div class="col-lg-3">
                <span class="sum clearfix">
                  <strong>Regiekosten</strong>
                  <!--<span>€ 11500,00</span>-->
                  <div class="col-lg-12 p-l-0 m-t-10">
                    <div class="has-hint has-hint2">
                      <span spi-hint text="_hint.fin_plan_school_overhead_cost.text"  title="_hint.fin_plan_school_overhead_cost.title" ></span>
                    </div>
                   <div class="wrap-hint" ng-class="{'wrap-line error': (( canAccept && fieldsError2(school.overhead_cost, 'Regiekosten' + '-' + key))  && errorShow)}">
                      <input type="text" class="form-control" ng-init = "numValidate2(school,'overhead_cost');" ng-change="numValidate(school,'overhead_cost');updateResultCost();" ng-model="school.overhead_cost" 
                             ng-disabled="data.status_finance == 'accepted' || !canAccept || !canEdit()">
                   </div>
                  </div>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="m-b-30">
          <div class="row m-b-15">
            <h3 class="panel-title title-custom col-lg-6">
              Berufsgenossenschaftsbeiträge
            </h3>
            <div class="col-lg-6 btn-row">
              <button class="btn w-xs pull-right" ng-click="prof_associations.push({})" ng-show="data.status_finance != 'accepted' && data.status_finance != 'acceptable' && data.status_finance != 'in_progress' && canFormEdit && canEdit()">Berufsgenossenschaft hinzufügen</button>
            </div>
          </div>
          <hr />
          <!--<ng-form name="financePlanFormGroup1" disable-all="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept)">-->
          <div class="row form-horizontal m-b-15" ng-repeat="(key, association) in prof_associations" ng-if="!association.is_deleted">
            <label class="col-lg-1 control-label">
              Name<span spi-hint text="_hint.fin_plan_association_name.text"  title="_hint.fin_plan_association_name.title"  class="has-hint"></span>
            </label>
            <div class="col-lg-7">
              <div class="wrap-hint" ng-class="{'wrap-line error': (prof_associations.length > 1 && fieldsError2(association.name, 'Berufsgenossenschaftsbeiträge-Name' + '-' + key) && errorShow) }">
                <input name = "first" class="form-control" type="text" 
                       ng-model="association.name"
                       ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()" >
              </div>
            </div>
            <label class="col-lg-1 p-r-0 control-label">
              Beitrag<span spi-hint text="_hint.fin_plan_association_sum.text"  title="_hint.fin_plan_association_sum.title"  class="has-hint"></span>
            </label>
            <div class="col-lg-2">
              <div class="wrap-hint" ng-class="{'wrap-line error': (prof_associations.length > 1 && fieldsError2(association.sum,  'Berufsgenossenschaftsbeiträge-Beitrag' + '-' + key) && errorShow) }">
                <input class="form-control" type="text" 
                       ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()"
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
        <div class="m-b-30">
          <h3 class="panel-title title-custom">
            Einnahmen
          </h3>
          <hr />
          <div class="row">
            <div class="col-lg-12 p-0 m-b-30">
              <div class="form-custom-box p-15 m-b-0 form-horizontal">
                <!--<ng-form name="financePlanFormGroup2" disable-all="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept)">-->
                <div class="form-group m-b-0">
                  <label class="col-lg-2 control-label bold-label">
                    Einnahmen<span spi-hint text="_hint.fin_plan_revenue_description.text"  title="_hint.fin_plan_revenue_description.title"  class="has-hint"></span>
                  </label>
                  <div class="col-lg-6">
                    <input name = "second" class="form-control" type="text" placeholder="Sonstige Einkommensquellen" 
                           ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()" 
                           ng-model="data.revenue_description" >
                  </div>
                  <label class="col-lg-1 control-label custom-width-label">
                    Betrag<span spi-hint text="_hint.fin_plan_revenue_sum.text"  title="_hint.fin_plan_revenue_sum.title"  class="has-hint"></span>
                  </label>
                  <div class="col-lg-2">
                    <input class="form-control" type="text" ng-disabled="data.status_finance == 'accepted' || (data.status_finance == 'in_progress' && !canAccept) || !canFormEdit || !canEdit()" 
                           ng-init = "data.revenue_sum = (data.revenue_sum || '0,00'); numValidate2(data,'revenue_sum');"  
                           ng-change="numValidate(data,'revenue_sum'); updateResultCost(); " ng-model="data.revenue_sum" >
                  </div>
                  <span class="symbol m-t-5">€</span>
                </div>
                 <!--</ng-form>-->
              </div>
            </div>
            <div class="holder-total clearfix">
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Personalkosten</strong>
                  <span>€ {{emoloyeesCost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Fortbildungskosten</strong>
                  <span>€ {{training_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Regiekosten</strong>
                  <span>€ {{overhead_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Berufsgenossenschaftsbeiträge</strong>
                  <span>€ {{prof_association_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0 custom-col">
                <div class="sum money-minus-ico">
                  <strong>Einnahmen</strong>
                  <span>€ {{revenue_sum||0| number:2}}</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 pull-right">
              <div class="clearfix box-recalculate">
                <div class="col-lg-12 text-center form-custom-box ">
                  <div class="sum total-sum">
                    <strong>Beantragte Fördermittel</strong>
                    <span>€ {{total_cost||0| number:2}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr />
        </div>
        <div class="row" ng-if="data.status_finance != 'accepted' && canAcceptEarly(data.status_finance)">
          <div class="col-lg-10">
              <span ng-if="canAccept && data.status_finance != 'rejected'">
                <h4 class="m-t-0">Prüfnotiz</h4>
                <textarea  placeholder="Tragen Sie den Text hier ein" ng-model="data.comment" class="form-control comments"></textarea>
              </span>
          </div>
          <div class="col-lg-2">
            <div class="m-t-30 text-right pull-right" ng-if="canAccept">
              <button ng-hide="data.status_finance == 'accepted' || !canEdit()" class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm('accepted')">AKZEPTIEREN</button>
              <button ng-hide="data.status_finance == 'rejected' || !canEdit()" ng-class="{disabled: !data.comment}" ng-click="submitForm('rejected')" class="btn w-lg btn-lg btn-danger">ANMERKUNG</button>
            </div>
            <div class="text-right pull-right" ng-if="canFormEdit && !canAccept && data.status_finance != 'in_progress' && data.status_finance != 'accepted' && canEdit()">
              <h4 class="m-t-0"></h4>
              <button class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm('in_progress')" title="Antragsteil zur Prüfung übermitteln">SENDEN</button>
            </div>
          </div>
        </div>
      </div>
      </ng-form>
    </div>
  </div>
</div>
