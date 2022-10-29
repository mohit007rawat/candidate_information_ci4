<div style="float: right;position: relative;right: 147px;z-index: 1;top: 4px;">
                <a class="nav-link" href="<?= base_url('candidate_curd/create') ?>"><i class="fa fa-plus-square"></i> Add New</a>
            </div>
<div class="card card-outline card-success rounded-0">
    <div class="card-header">
        <h4 class="mb-0">List of Candidate</h4>
    </div>
    <div class="card-body">
        <div style="float:right">
            <form method="post" action="<?= base_url('candidate_curd/index') ?>" >
                <?= csrf_field() ?>
                <input type="text"  value="<?= isset($search_data) ? $search_data : '' ?>" required="required"  placeholder="Search Here" name="search_data">
                <input type="submit" class="btn btn-primary"  value="Search">
            </form>

        </div>
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="40%">
                    <col width="40%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient bg-success text-light">
                        <th class="py-1 text-center">#</th>
                        <th class="py-1 text-center">Name</th>
                        <th class="py-1 text-center">Email</th>
                        <th class="py-1 text-center">Mobile Number</th>
                        <th class="py-1 text-center">Gender</th>
                        <th class="py-1 text-center">Education Qualification</th>
                        <th class="py-1 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="xyz">
                    <?php if(count($list) > 0): ?>
                        <?php $i = 1; ?>
                        <?php foreach($list as $row): ?>
                            <tr>
                                <th class="p-1 align-middle text-center"><?= $i++ ?></th>
                                <td class="p-1 align-middle"><?= $row->name ?></td>
                                <td class="p-1 align-middle"><?= $row->email ?></td>
                                <td class="p-1 align-middle"><?= $row->contact ?></td>
                                <td class="p-1 align-middle"><?= $row->gender ?></td>
                                <td class="p-1 align-middle"><?= $row->education_qualification ?></td>
                                <td class="p-1 align-middle text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('candidate_curd/view_pdf/'.$row->id) ?>" class="btn btn-default bg-gradient-light border text-dark rounded-0" title="View Candidate details"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url('candidate_curd/edit/'.$row->id) ?>" class="btn btn-primary rounded-0" title="Edit Candidate details"><i class="fa fa-edit"></i></a>
                                        <a href="<?= base_url('candidate_curd/delete/'.$row->id) ?>" onclick="if(confirm('Are you sure to delete this Candidate details?') === false) event.preventDefault()" class="btn btn-danger rounded-0" title="Delete Candidate details"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>