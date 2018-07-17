
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
if(document.getElementById('home'))
{
const API = 'https://stomatime.com/api/cabinete';
class SearchBar extends Component 
{
    constructor(props) {
      super(props);
      this.handleFilterTextChange = this.handleFilterTextChange.bind(this);
      this.handleFilterJudetChange = this.handleFilterJudetChange.bind(this);
    }
    
    handleFilterTextChange(e) {
      this.props.onFilterTextChange(e.target.value);
    }
    handleFilterJudetChange(e) {
        this.props.onFilterJudetChange(e.target.value);
      }
    
    render() {
      return (
       <section>
          <input
          className="form-control"
            type="text"
            placeholder="Caută un cabinet dupa denumire."
            value={this.props.filterText}
            onChange={this.handleFilterTextChange}
          />
        
                            <label  className="col-form-label text-md-right">Județ</label>

                            <div>
                                <select name="judet" className="form-control" onChange={this.handleFilterJudetChange}>
                                    <option value="">Toate</option>
                                    <option value="Alba">Alba</option>
                                    <option value="Arad">Arad</option>
                                    <option value="Arges">Arges</option>
                                    <option value="Bacau">Bacau</option>
                                    <option value="Bihor">Bihor</option>
                                    <option value="Bistrita Nasaud">Bistrita Nasaud</option>
                                    <option value="Botosani">Botosani</option>
                                    <option value="Brasov">Brasov</option>
                                    <option value="Braila">Braila</option>
                                    <option value="Bucuresti">Bucuresti</option>
                                    <option value="Buzau">Buzau</option>
                                    <option value="Caras Severin">Caras Severin</option>
                                    <option value="Calarasi">Calarasi</option>
                                    <option value="Cluj">Cluj</option>
                                    <option value="Constanta">Constanta</option>
                                    <option value="Covasna">Covasna</option>
                                    <option value="Dambovita">Dambovita</option>
                                    <option value="Dolj">Dolj</option>
                                    <option value="Galati">Galati</option>
                                    <option value="Giurgiu">Giurgiu</option>
                                    <option value="Gorj">Gorj</option>
                                    <option value="Harghita">Harghita</option>
                                    <option value="Hunedoara">Hunedoara</option>
                                    <option value="Ialomita">Ialomita</option>
                                    <option value="Iasi">Iasi</option>
                                    <option value="Ilfov">Ilfov</option>
                                    <option value="Maramures">Maramures</option>
                                    <option value="Mehedinti">Mehedinti</option>
                                    <option value="Mures">Mures</option>
                                    <option value="Neamt">Neamt</option>
                                    <option value="Olt">Olt</option>
                                    <option value="Prahova">Prahova</option>
                                    <option value="Satu Mare">Satu Mare</option>
                                    <option value="Salaj">Salaj</option>
                                    <option value="Sibiu">Sibiu</option>
                                    <option value="Suceava">Suceava</option>
                                    <option value="Teleorman">Teleorman</option>
                                    <option value="Timis">Timis</option>
                                    <option value="Tulcea">Tulcea</option>
                                    <option value="Vaslui">Vaslui</option>
                                    <option value="Valcea">Valcea</option>
                                    <option value="Vrancea">Vrancea</option>
                                </select>
                            </div>
        </section>
      );
    }
  }
class Cabinete extends Component{

    render()
    {
        const search = this.props.filterText;
        const judet = this.props.judet;
        const cabs = this.props.cabinete;
        const row = [];
        cabs.forEach((cabinet,index)=>
        {
            if(cabinet.name.toLowerCase().indexOf(search.toLowerCase()) === -1){
                return;
            }
            if(cabinet.judet.indexOf(judet) === -1){
                return;
            }
            row.push(  
                <Cards cabinet={cabinet} key={index}/>
            )
        })
        return(
            <div className="row flex-row">
            {row}
             <br/>
            </div>
        );
    }

}
class Cards extends Component{
    render()
    {
        const cabinet = this.props.cabinet;
        return(
            <div className="col- col-md-6 col-lg-4 col-xl-2 col-sm-4  d-md-flex d-sm-flex d-lg-flex d-xl-flex">
            <div className="card mt-3 p-2 flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill text-center d-md-flex d-sm-flex d-lg-flex d-xl-flex" width="20rem">
                {
                cabinet.img_profile!=null
                ?
                <a href={"/view/"+cabinet.id}>
                  <img
                    src={ cabinet.img_profile }
                    alt="Aici vine o poza pusa de cabinet"
                    className="card-img-top"
                    width="200px" height="200px"/>
                    </a> 
                :
                <a href={"/view/"+cabinet.id}>
                    <img src="/storage/logo.png" alt="Aici vine o poza pusa de cabinet"  className="card-img-top"  width="200px" height="200px"/>
                </a> 
                }
                <div className="card-body flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill ">
                <hr/>
                   <a className="card-text"  href={"/view/"+cabinet.id}>
                       <h6 className="card-title">{cabinet.name}</h6>
                    </a> 
                    <hr/>
                    {
                        cabinet.moto!=null
                        ?
                        <div>
                         <cite title="Source Title">"{cabinet.moto}"</cite>
                        <hr/>
                      
                        </div>
                        :
                        <br/>
                    }
                    {
                        cabinet.descriere!=null
                        ?
                        <p className="card-text">{cabinet.descriere}</p>
                        :
                        <br/>
                    }                   
                </div>
                {
                    cabinet.adresa!=null
                    ?
                    <div className="card-footer text-muted flex-sm-fill flex-md-fill flex-lg-fill flex-xl-fill ">
                    <p className="card-text">{cabinet.adresa} <br/>{cabinet.numar!=null ?  ' Contact: '+ cabinet.numar:<br/>}</p>
                </div>
                    :
                    <br/>
                }
            </div>
            </div>
        );
    }
}
class Main extends Component {
    constructor(props) {
      super(props);
      this.state = {
        filterText: '',
        judet:'',
        cabinete: []
      };
      
      this.handleFilterTextChange = this.handleFilterTextChange.bind(this);
      this.handleFilterJudetChange = this.handleFilterJudetChange.bind(this);
    }
    componentDidMount() 
    {
            axios.get(API)
      .then((res) => {
      this.setState({
          cabinete:res.data
          
      });
    })
  }
    handleFilterTextChange(filterText) {
      this.setState({
        filterText: filterText
      });
    }
    handleFilterJudetChange(judet) {
        this.setState({
            judet: judet
        });
      }

    render() {
      return (
        <div  className="container-fluid">
       
            <SearchBar
                        filterText={this.state.filterText}
                        filterJudet={this.state.judet}
                        onFilterTextChange={this.handleFilterTextChange}
                        onFilterJudetChange={this.handleFilterJudetChange}
            />
           
            
            <Cabinete
                cabinete={this.state.cabinete}
                filterText={this.state.filterText}
                judet={this.state.judet}
            />
          
        </div>
      );
    }
  }
ReactDOM.render(<Main/>, document.getElementById('home'));
}

