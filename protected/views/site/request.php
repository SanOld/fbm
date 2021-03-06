<?php
$this->pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge'=>'/requests', 'Antrag {{request_code}}');
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/diff_match_patch.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/request.js"></script>

<div class="wraper container-fluid" ng-controller="RequestController">
	<div class="row">
		<div class="container center-block request-edit-page">
      <div spi-hint-main ng-show="tabActive == 'project-data'" header="_hint.projectData.title" text="_hint.projectData.text" ng-cloack></div>
      <div spi-hint-main ng-show="tabActive == 'finance-plan'" header="_hint.finData.title" text="_hint.finData.text" ng-cloack></div>
      <div spi-hint-main ng-show="tabActive == 'school-concepts'" header="_hint.conceptData.title" text="_hint.conceptData.text" ng-cloack></div>
      <div spi-hint-main ng-show="tabActive == 'schools-goals'" header="_hint.goalData.title" text="_hint.goalData.text" ng-cloack></div>

			<div class="panel panel-default" ng-cloak>
				<div class="panel-heading heading-noborder clearfix">
                  <h1 class="panel-title col-lg-6">Заказ {{requestYear}} <span ng-show="projectID">({{projectID}})</span>  #{{requestID}}</h1>
<!--					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
					</div>-->
				</div>
        <ng-form name="form">
            <button ng-if="userCan('send')" class="btn w-lg btn-lg btn-success m-b-10 m-t-30 pull-right" ng-click="sendToAccept()">Zur Prüfung übermitteln</button>
				<uib-tabset class="panel-body request-order-nav" active="tabActive" ng-cloack>
					<uib-tab class="project" index="'project-data'" select="setTab('project-data')" heading="Данные заказа">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-project-data.php'); ?>
          </uib-tab>
          <uib-tab class="schools-goals {{goalsStatus}}"  index="'order-list'" select="setTab('order-list')" heading="Состав заказа">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-order-list.php'); ?>
          </uib-tab>
          <uib-tab class="finance {{financeStatus}}"  index="'payments'" select="setTab('payments')" heading="Платежи">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-payments.php'); ?>
          </uib-tab>
					<uib-tab class="concepts {{conceptStatus}}" index="'school-concepts'" select="setTab('school-concepts')" heading="Статус заказа">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-concept-data.php'); ?>
					</uib-tab>
          <uib-tab class="schools-goals {{goalsStatus}}"  index="'status'" select="setTab('schools-goals')" heading="Документы">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-goals-data.php'); ?>
          </uib-tab>
					<uib-tab ng-if="isFinansist || (is_bonus_project == '1' && user_type == 's')" class="concepts {{conceptStatus}}" index="'finance-plan'" select="setTab('finance-plan')" heading="Приложение">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-financial-plan.php'); ?>
					</uib-tab>
				</uib-tabset>
				<br>
				<div class="form-group group-btn row no-print">
					<div class="col-lg-{{(userCan('changeStatus_print') || userCan('changeStatus_lock')) && userCan('reopen') ? '6' : '5'}} text-left">
            <a ng-show="userCan('delete')" class="btn-deactivate request" ng-click="block()" id="sa-warning">Отклонить</a>
<!--						<button ng-show="userCan('delete')" ng-click="block()" class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>-->
						<button ng-show="userCan('reopen') && !banToReopen" class="btn w-lg custom-btn btn-lg {{userCan('changeStatus_print') || userCan('changeStatus_lock') && userCan('reopen')? 'request-new-open' : ''}}" ng-click="setBulkStatus(3)">
							<i class="fa fa-rotate-left"></i>
							<span>В работе</span>
						</button>
						<button ng-show="userCan('changeStatus_print')" class="btn w-lg custom-btn btn-lg {{userCan('changeStatus_print') && userCan('delete') && !userCan('reopen') ? 'request-acceptable' : user.type != 'p' ? 'request-acceptable-reopen' : ''}}" ng-click="setBulkStatus(4)" title="Antrag ist förderfähig">Подготовлен</button>
						<button ng-show="userCan('changeStatus_lock')" class="btn w-lg custom-btn btn-lg {{userCan('changeStatus_lock') && userCan('delete') ? 'request-accept' : ''}}" ng-click="setBulkStatus(5)" title="Antrag genehmigen">В производство</button>
					</div>
          <div class="col-lg-2 text-left">
            <button class="btn w-lg cancel-btn btn-lg {{(userCan('changeStatus_print') || userCan('changeStatus_lock') || userCan('reopen')) && userCan('delete') ? 'request-back' : ''}}" ng-click="cancel()" title="Abbrechen">В список заказов</button>
					</div>
					<div class="col-lg-{{(userCan('changeStatus_print') || userCan('changeStatus_lock')) && userCan('reopen') ? '4' : '5'}} text-right">
						<button ng-show="userCan('save') && back" class="btn m-t-2 custom-btn btn-lg ion-skip-backward" ng-click="submitRequest();toTab(-1)" title="Сохранить и перейти на предыдущую вкладку "></button>
						<button ng-show="userCan('save')" class="btn w-lg save-btn btn-lg fa fa-floppy-o fa-5x" ng-click="submitRequest(true)" title="Сохранить и остаться"></button>
						<button ng-show="userCan('save') && next"  class="btn m-t-2 custom-btn btn-lg ion-skip-forward" ng-click="submitRequest();toTab(1)" title="Сохранить и перейти на следующую вкладку"></button>
         </div>  
				</div>
        </ng-form> 
			</div>
		</div>
	</div>
</div>


<script type="text/ng-template" id="setDuration.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Datum ändern</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 p-0">
							<label>Beginn</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<div class="col-lg-2 p-0">
							<label>Ende</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_due_date_is_open = !dp_due_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
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
					<button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled=" form.$invalid || form.due_date < form.start_date ">Speichern</button>
				</div>
			</div>
		</div>
	</div>
</script>


<script type="text/ng-template" id="conceptCompareTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Vergleichen</h3>
			<button ng-click="cancel()" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body">
			<div class="heading-compare">
				<strong>Veränderungen</strong>
				<span>Bearbeitet von {{::history.user_name}} am {{::history.date}}</span>
				<p>Bereich: <strong ng-bind="::history.name"></strong></p>
			</div>
			<hr />
			<div class="row compare-box">
        <div class="col-lg-12 emphasize" ng-bind-html="::compareText"></div>
      </div>
			<hr />
		</div>
		<div class="row">
			<div class="form-group group-btn">
				<div class="col-lg-12">
					<button ng-click="cancel()" class="btn w-lg custom-btn pull-right" data-dismiss="modal">SCHLIEßEN</button>
				</div>
			</div>
		</div>
	</div>
</script>


<script type="text/ng-template" id="setEndFill.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Дата окончания этапа</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 col-lg-offset-2 p-0">
							<Select>Abgabe
      <option>1
       <option>2
              </select>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.end_fill" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</ng-form>
			</div>
		</div>
		<div class="row p-t-10 text-center">
			<div class="form-group group-btn m-t-20">
				<div class="col-lg-12">
					<button class="btn w-lg cancel-btn" ng-click="cancel()">Отменить</button>
					<button class="btn w-lg custom-btn" ng-click="ok()"  ng-disabled="form.$invalid">Принять</button>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="sendToAccept.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix"> 
      <h3 class="m-0 pull-left">Antragsteile zur Prüfung übermitteln</h3>
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div> 
    <div class="panel-body text-center">
      <ng-form name="sendToAccept">
        <h3 class="m-b-10 p-b-10">Folgende Antragsteile werden zur Prüfung übermittelt:</h3>
          <div class="checkbox p-b-10 clearfix custom-m-l-30" ng-if="user.is_finansist == 1">
            <label class="cr-styled pull-left" for="finance"><input name="finance" id="finance" type="checkbox" ng-model="checkboxes.finance"><i class="fa"></i>Finanzplan</label>
          </div>
          <div class="checkbox p-b-10 clearfix custom-m-l-30">
            <label class="cr-styled pull-left" for="concept"><input name="concept" id="concept" type="checkbox" ng-model="checkboxes.concept"><i class="fa"></i>Konzept</label>
          </div>
          <div class="checkbox p-b-10 clearfix custom-m-l-30">
            <label class="cr-styled pull-left" for="goal"><input name="goal" id="goal" type="checkbox" ng-model="checkboxes.goal"><i class="fa"></i>Entwicklungsziele</label>
          </div>
        <div class="col-lg-12">
          <span>Hinweis: Abgesendete Antragsteile können während der Prüfung nicht bearbeitet werden.</span>
        </div>
      </ng-form>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="send()">Senden</button>
        </div>
      </div>
    </div>
  </div>
</script>
