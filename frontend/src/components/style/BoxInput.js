import React  from 'react';

export const BoxInput = ({description, btnDescription, buttonType, maxLength, placeholderDescription, handleForm, errorMsg = "", countInput, showInput }) =>
  <form onSubmit={ handleForm }>
        <div className="my-3 p-3 bg-white rounded shadow-sm">
            <h6 className="border-bottom border-gray pb-2 mb-0">{description} {showInput}</h6>
            <span className="d-block text-right mt-3">
                <input 
                    className="form-control form-control-sm" 
                    maxLength={maxLength}
                    type="text"
                    name="document"
                    onKeyUp = {countInput}
                    placeholder={placeholderDescription} />
            </span>
            <div className="row">
                <div className="col">
                    <div className="pt-3 text-right small error">
                        {errorMsg}
                    </div>
                </div>
                <div className="col-md-3 col-sm-3">
                    <div className="pt-2 text-right">
                        <button type="submit" className={`btn btn-sm ${buttonType}`}  >{btnDescription}</button>
                    </div>
                </div>
            </div>
        
        </div>
    </form>

