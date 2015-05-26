<div id="content-header" class="mini">
    <h1>Projects</h1>
    <div class="btn-group">
        <a href="/cms/project/create" class="btn btn-large" title="Add new Project"><i class="fa fa-plus"></i></a>
    </div>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/project/index" class="current">Projects</a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-th"></i></span>
                <h5>Projects</h5>
                <a href="/cms/project/list" class="right"><span class="icon"><i class="fa fa-th-list"></i></span></a>
            </div>

            <div class="widget-content">
                <?php
                //var_dump($model);die;
                foreach ($model as $a){
                    $data = $a->attributes;

                    if (!empty($data['logo'])) {
                        $image = Utils::imageUrl("..".DS."files".DS."projects".DS.$data['logo']);
                        echo '<div class="project_button" style="background-image:url(\''.$image.'\');">';
                            echo '<p class="projects_options">';
                                echo '<a href="/cms/project/update/'.$data['id'].'"><image src="'.Utils::imageUrl("button_edit.png").'" /></a>';
                                echo '<a href="/cms/project/delete/'.$data['id'].'"><img src="'.Utils::imageUrl("button_delete.png")    .'"/></a>';
                            echo '</p>';
                            echo '<p class="project_lupa">';
                                echo '<a href="/cms/project/view/'.$data['id'].'" class="project_button_small">';
                                echo '</a>';
                            echo '</p>';
                        echo '</div>';

                    } else {
                        $image = Utils::imageUrl("..".DS."files".DS."plus-empty_128.png");
                        echo '<div class="project_button" style="background-image:url(\''.$image.'\');">';
                            echo '<p class="projects_options">';
                                echo '<a href="/cms/project/update/'.$data['id'].'"><image src="'.Utils::imageUrl("button_edit.png").'" /></a>';
                                echo '<a href="/cms/project/delete/'.$data['id'].'"><img src="'.Utils::imageUrl("button_delete.png")    .'"/></a>';
                            echo '</p>';
                            echo '<p class="project_lupa">';
                                echo '<a href="/cms/project/view/'.$data['id'].'" class="project_button_small">';
                                echo '</a>';
                            echo '</p>';
                            echo '<p class="project_name">'.$data['name'].'</p>';
                        echo '</div>';
                    }




                }
                ?>
            </div>
        </div>
    </div>
    <div id="content-footer" class="mini">
        <div class="btn-group">
            <a href="/cms/project/create" class="btn btn-large" title="Add new Project"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
