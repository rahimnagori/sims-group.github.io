<div class="form-group">
  <label> Plan Name </label>
  <input type="text" class="form-control" required name="plan_name" value="<?=$planDetails['plan_name'];?>" >
  <input type="hidden" required name="plan_id" value="<?=$planDetails['id'];?>" >
</div>

<div class="form-group">
  <label> Plan Description </label>
  <textarea class="form-control textarea-edit" id="edit-description" required name="plan_description"><?=$planDetails['plan_description'];?></textarea>
</div>

<div class="form-group">
  <label class="control-label" for="prependedtext"> Plan Fee </label>
  <div class="input-group">
    <span class="input-group-addon">$</span>
    <input type="number" class="form-control" required name="plan_fee" step="0.01" value="<?=$planDetails['plan_fee'];?>" >
  </div>
</div>

<div class="form-group">
  <label> Monthly Credits </label>
  <input type="number" class="form-control" required name="monthly_credits" step="1" value="<?=$planDetails['monthly_credits'];?>" >
</div>

<div id="editResponseMessage"></div>