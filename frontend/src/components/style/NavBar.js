import React  from 'react';

export const NavBar = () =>
<header>
  <div className="navbar navbar-dark navbar-background shadow-sm">
    <div className="container d-flex ">
        <div className="navbar-brand d-flex">
            <div className="col-md-1 text-left">
                <i className="fa fa-list-alt"></i>
            </div>
            <div className="col-md text-left">
                <strong>Lista de tarefas</strong>
            </div>
        </div>
    </div>
  </div>
</header>