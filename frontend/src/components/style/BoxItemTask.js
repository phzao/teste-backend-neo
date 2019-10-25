import React  from 'react';

export const BoxItemTask = ({colorBox, task, onDone, onOpen, onDelete}) =>
<div className="row border-bottom border-gray pt-2 pb-2 mb-2">
    <div className="col-md-1 text-center">
        <svg className="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill={colorBox}/><text x="50%" y="50%" fill={colorBox} dy=".3em">32x32</text></svg>
    </div>
    <div className="col-md-9 text-center pt-1">
        <span className="d-block text-gray-dark title-task">{task.done_at!==null?<strike>{task.title}</strike>:task.deleted_at!==null?<i>{task.title}</i>:<b>{task.title}</b> }</span>
    </div>
    {(task.deleted_at===null && task.done_at===null) &&
        <div className="col-md-1 text-center">
            <button type="button" className="btn" onClick={()=>onDone()} title="Task concluída"><i className="fa fa-check done-check"></i></button>
    </div> }
    {(task.deleted_at===null && task.done_at===null) &&
        <div className="col-md-1 text-center">
            <button type="button" className="btn" onClick={()=>onDelete()} title="Remover task"><i className="fa fa-trash remove-task"></i></button>
        </div>}
    {(task.deleted_at!==null || task.done_at!==null) &&
        <div className="col-md-1 text-center">
            <button type="button" className="btn" onClick={()=>onOpen()} title="Reabrir task">
                <i className="fa fa-refresh reopen-task"></i></button>
        </div>}
</div>