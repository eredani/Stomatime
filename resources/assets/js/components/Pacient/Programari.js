
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import {NotificationContainer, NotificationManager} from 'react-notifications';
import 'react-notifications/lib/notifications.css';
if(document.getElementById('reactprogramari'))
{
    
    const Token = window.config.csrfToken;
    const API = 'https://stomatime.com/programari/me';
    class Modal extends Component{
        constructor(props)
        {
            super(props);
            this.state ={
                code:''
            };
            this.sendConfirm=this.sendConfirm.bind(this);

            this.setCode = this.setCode.bind(this);
        }
        sendConfirm(medicID,cabID,id)
        {
            if(this.state.code!=='')
            {
                axios.post(`https://stomatime.com/confirmare`,
                { 
                cod: this.state.code,
                id_medic: medicID,
                id_cab: cabID,
                id:id,
                csrfToken: Token 
                }
                )
                .then(res => {
                    switch (res.data.status) {
                        case 'fail': {
                            NotificationManager.error('Error', res.data.msg, 3000);
                            break;
                        }
                        case 'success': {
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.props.update();
                            this.setState({code:'',confirm:false});
                            this.forceUpdate();
                            break;
                        }
                    }
                })
            }
            else{ 
                NotificationManager.error('Error', "Codul nu este bun.", 3000);
            }
        }
        cancelProg(medicID,cabID,id)
        {
           
                axios.post(`https://stomatime.com/cancel`,
                { 
                id:id,
                id_medic: medicID,
                id_cab: cabID,
                csrfToken: Token 
                }
                )
                .then(res => {
                    switch (res.data.status) {
                        case 'fail': {
                            NotificationManager.error('Error', res.data.msg, 3000);
                            break;
                        }
                        case 'success': {
                            NotificationManager.success('Success', res.data.msg, 3000);
                            this.props.update();
                            this.forceUpdate();
                            break;
                        }
                    }
                })
            
        }
        setCode(e){
            this.setState({code:e.target.value});
        }
        render()
        {
            var data= this.props.data;
            return(
                <div className="text-center">
                <button type="button" className="btn btn-primary" data-toggle="modal" data-target={"#set"+data.id}>
                <i className="fa fa-pencil-square-o"/>
                </button>
                <div className="modal" id={"set"+data.id}>
                <div className="modal-dialog">
                    <div className="modal-content">        
                    <div className="modal-header">
                        <h4 className="modal-title">{data.cabinet} | {data.medic}</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div className="modal-body">
                        {data.confirmat==0 && 
                        <div>
                    <div className="form-group">
                                <label htmlFor={"cod"+data.id}>Cod de confirmare</label>
                                <input type="number" className="form-control" id={"cod"+data.id} onChange={this.setCode} value={this.state.cod} aria-describedby={"cod"+data.id} placeholder="Cod de confirmare" required/>
                     </div>
                            <button type="submit" id={"conf"+data.id} onClick={this.sendConfirm.bind(this,data.id_doctor,data.id_cab,data.id)} className="btn btn-primary">Confirmă</button>
                   </div>
                        }
                        {data.status!==2 &&
                            <div>
                        <p>Poți anula programarea apăsând pe butonul de mai jos</p>
                         <button type="submit" id={"delete"+data.id} onClick={this.cancelProg.bind(this,data.id_doctor,data.id_cab,data.id)} className="btn btn-danger">Anulează</button>
                        </div>}
                        </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Închide</button>
                    </div>
                        
                    </div>
                </div>
                </div>
                </div>
            );
        }
    }
    class Row extends Component{

        render()
        {
            var prog=this.props.programare;
            return(
                <tr>
                    <td><a href={"https://stomatime.com/view/"+prog.id_cab}>{prog.cabinet}</a></td>
                    <td><a href={"https://stomatime.com/view/"+prog.id_cab+"/medic/"+prog.id_doctor}>{prog.medic}</a></td>
                    <td>+{prog.numar}</td>
                    <td>{prog.data}</td>
                    <td>{prog.ora}</td>
                    <td>{prog.status==0 ? <span className="badge badge-info">Asteptare</span> : prog.status==2 ? <span className="badge badge-danger">Anulat</span> :<span className="badge badge-success">Acceptat</span> }</td>
                    <td>{prog.confirmat==0 ? <span className="badge badge-info">Neconfirmat</span> : <span className="badge badge-success">Confirmat</span>}</td>
                    <td><Modal update={this.props.update} data={prog}/></td>
                    </tr>
            );
        }
    }
    class Main extends Component{
        constructor(props)
        {
            super(props);
            this.state = {
                date: []
              };
              this.update=this.update.bind(this);
        }
        update()
{
    axios.get(API)
    .then((res) => {
    this.setState({
        date:res.data
        
    });
    })
}
        componentDidMount()
        {
       this.update();
        }
        render()
        {
            var rows=[];
            this.state.date.forEach((programare,key)=>{
                rows.push(<Row programare={programare} update={this.update} key={key}/>)
            });
            return(
                <div>
               <table className="table text-center">
                   <thead>
                       <tr>
                           <th>Cabinet</th>
                           <th>Doctor</th>
                           <th>Număr</th>
                           <th>Dată</th>
                           <th>Oră</th>
                           <th>Status</th>
                           <th>Confirmat</th>
                           <th>Setări</th>
                           </tr>
                    </thead>
                    <tbody>
                        {rows}
                </tbody>
                    <tfoot>
                    <tr>
                           <th>Cabinet</th>
                           <th>Doctor</th>
                           <th>Număr</th>
                           <th>Dată</th>
                           <th>Oră</th>
                           <th>Status</th>
                           <th>Confirmat</th>
                           <th>Setări</th>
                           </tr>
                </tfoot>
                   </table>
                   <NotificationContainer/>
                   </div>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('reactprogramari'));
}