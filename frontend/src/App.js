import React, { Component } from 'react';
import './App.css';
import { MyBody } from './components/style/Body';
import { NavBar } from './components/style/NavBar';
import Modal from 'react-modal';
import BoxNewItem from './components/style/BoxNewItem';
import BoxList from './components/style/BoxList';

Modal.setAppElement('#root')

class App extends Component {
  constructor() {
    super();
    this.state = {
      document:{}
    }
  }

  render() {
    const { document } = this.state
    return (
      <MyBody>
        <NavBar />
        <BoxNewItem 
          newItem={(document)=>this.setState({document: document})} />
        <BoxList
          addItem={document}
          refreshItem={()=>this.setState({document:{}})} />
      </MyBody>
    );
  }
}

export default App;
