<!-- BEGIN ADVANCED SEARCH -->
<h2 class="section-title">Search Doctor</h2>
<form method="get" action="<?= site_url('doctors') ?>">
    <div class="form-group">
        
        <div class="col-sm-12">
            <input type="text" class="form-control" name="location" placeholder="City,Location">
            
            <select class="col-sm-12" id="search_prop_type" name="work_type" data-placeholder="Category">
                <option value=""> </option>
                <?php foreach($categories as $s): ?>
                <option value="<?= $s->id ?>"><?= $s->name ?></option>
                <?php endforeach; ?>
             
            </select>
        

        </div>
        
         
        
         
        
        <p>&nbsp;</p>
        <p class="center">
            <button type="submit" class="btn btn-default-color">Search</button>
        </p>
    </div>
</form>
<!-- END ADVANCED SEARCH -->