import React, { useRef, useState, useEffect } from "react";
import SideBar_AccountSettings from './SideBar_AccountSettings'; 
import { withTokenRequest, requestHeaders } from '../../../http';
import Uploady from "@rpldy/uploady";
import UploadButton from "@rpldy/upload-button";
import UploadPreview from "@rpldy/upload-preview";
import "../../modules/crop/Crop.css";
import "../../modules/crop/CropImage";
import noImage from "../../../assets/img/no image/noimage.png"
import { deleteBackSlash } from "../../../utils/function";
import { ItemPreviewWithCrop, mockSenderEnhancer } from "../../modules/crop/CropImage";

const ImageSettings = () => {
    const previewMethodsRef = useRef();
    const [profileIconPass, setProfileIconPass] = useState(null);
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    const date= Date.now();

    useEffect(() => {
        getProfileIcon();
    }, []);

    function getProfileIcon() {
        withTokenRequest.post('./getProfileIcon', {user_id: localStorage.getItem('user_id')},
            {headers: requestHeaders}
        )
        .then((res) => {
            if (!res.data.data.profileIconPass) {
                setProfileIconPass(noImage)
            } else {
                setProfileIconPass('../../storage/' + deleteBackSlash(res.data.data.profileIconPass));
            }
        });
    }

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    }

    const iconSettings = {
        float: 'left',
        margin: '10px',
        padding: '10px',
    }

    const iconStyle = {
        width: '200px',
        height: '200px'
    }

    const mainProfilePictureSettings = {
        float: 'left',
        margin: '10px',
        padding: '10px',
    }

    const mainPictureStyle = {
        width: '200px',
        height: '250px'
    }

    return (
        <>
            <SideBar_AccountSettings />
            <div style={mainContents}>
                <div className="mainPicture">
                    <Uploady
                        multiple={false}
                        //destination={{ url: "[upload-url]" }}
                        //enhancer={mockSenderEnhancer}
                    >
                        <div className="mainProfilePictureSettings" style={mainProfilePictureSettings}>
                            Main Picture<br></br>
                            <img src={noImage} alt="picture" style={mainPictureStyle}></img><br></br>
                            <UploadButton>SETTINGS</UploadButton>
                            <br />
                        <UploadPreview
                            PreviewComponent={ItemPreviewWithCrop}
                            previewComponentProps={{ previewMethods: previewMethodsRef, aspectProps: 4 / 5, api: 'setMainProfilePicture', aspectControllButtonsVisible: true, inputTextVisible: true}}
                            previewMethodsRef={previewMethodsRef}
                        />
                        </div>
                    </Uploady>
                </div>
                <Uploady
                    multiple={false}
                    destination={{ url: "[upload-url]" }}
                    //enhancer={mockSenderEnhancer}
                >
                    <div className="IconSettings" style={iconSettings}>
                        Icon<br></br>
                        <img src={profileIconPass + "?" + date} alt="picture" style={iconStyle}></img><br></br>
                        <UploadButton>SETTINGS</UploadButton>
                        <br />
                    <UploadPreview
                        PreviewComponent={ItemPreviewWithCrop}
                        previewComponentProps={{ previewMethods: previewMethodsRef, aspect: 1 / 1, api: 'setProfileIcon', aspectControllButtonsVisible: false, inputTextVisible: false }}
                        previewMethodsRef={previewMethodsRef}
                    />
                    </div>
                </Uploady>
            </div>
        </>
    );
}

export default ImageSettings;

