VERSION 5.00
Object = "{EAB22AC0-30C1-11CF-A7EB-0000C05BAE0B}#1.1#0"; "shdocvw.dll"
Begin VB.Form frmMain 
   BackColor       =   &H00000000&
   BorderStyle     =   0  'None
   Caption         =   "Form1"
   ClientHeight    =   11760
   ClientLeft      =   0
   ClientTop       =   0
   ClientWidth     =   17955
   ControlBox      =   0   'False
   Icon            =   "Form1.frx":0000
   KeyPreview      =   -1  'True
   LinkTopic       =   "Form1"
   ScaleHeight     =   784
   ScaleMode       =   3  'Pixel
   ScaleWidth      =   1197
   ShowInTaskbar   =   0   'False
   StartUpPosition =   2  '屏幕中心
   Begin VB.TextBox txtAddress 
      Height          =   270
      Left            =   1080
      TabIndex        =   2
      Top             =   120
      Visible         =   0   'False
      Width           =   14895
   End
   Begin VB.CommandButton cmdExit 
      Caption         =   "退出"
      Height          =   375
      Left            =   17160
      TabIndex        =   0
      Top             =   120
      Width           =   615
   End
   Begin SHDocVwCtl.WebBrowser WebBrowser2 
      Height          =   10815
      Left            =   9240
      TabIndex        =   4
      Top             =   720
      Width           =   8415
      ExtentX         =   14843
      ExtentY         =   19076
      ViewMode        =   0
      Offline         =   0
      Silent          =   0
      RegisterAsBrowser=   0
      RegisterAsDropTarget=   1
      AutoArrange     =   0   'False
      NoClientEdge    =   0   'False
      AlignLeft       =   0   'False
      NoWebView       =   0   'False
      HideFileNames   =   0   'False
      SingleClick     =   0   'False
      SingleSelection =   0   'False
      NoFolders       =   0   'False
      Transparent     =   0   'False
      ViewID          =   "{0057D0E0-3573-11CF-AE69-08002B2E1262}"
      Location        =   "http:///"
   End
   Begin SHDocVwCtl.WebBrowser WebBrowser1 
      Height          =   10815
      Left            =   360
      TabIndex        =   3
      Top             =   720
      Width           =   8535
      ExtentX         =   15055
      ExtentY         =   19076
      ViewMode        =   0
      Offline         =   0
      Silent          =   0
      RegisterAsBrowser=   0
      RegisterAsDropTarget=   1
      AutoArrange     =   0   'False
      NoClientEdge    =   0   'False
      AlignLeft       =   0   'False
      NoWebView       =   0   'False
      HideFileNames   =   0   'False
      SingleClick     =   0   'False
      SingleSelection =   0   'False
      NoFolders       =   0   'False
      Transparent     =   0   'False
      ViewID          =   "{0057D0E0-3573-11CF-AE69-08002B2E1262}"
      Location        =   "http:///"
   End
   Begin VB.Timer timerWatchman 
      Enabled         =   0   'False
      Interval        =   50
      Left            =   16200
      Top             =   120
   End
   Begin VB.Label lblProgress 
      Caption         =   "lblProgress"
      Height          =   255
      Left            =   120
      TabIndex        =   1
      Top             =   120
      Visible         =   0   'False
      Width           =   495
   End
End
Attribute VB_Name = "frmMain"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Private Declare Function SetWindowPos Lib "user32" (ByVal hwnd As Long, ByVal hWndInsertAfter As Long, ByVal x As Long, y, ByVal cx As Long, ByVal cy As Long, ByVal wFlags As Long) As Long
Private Const HWND_TOPMOST = -1
Private Const HWND_NOTOPMOST = -2
Private Const SWP_NOMOVE = &H2
Private Const SWP_NOSIZE = &H1
Private Const TOPMOST_FLAGS = SWP_NOMOVE Or SWP_NOSIZE
Private Const VERSION As String = "'sExam Client Application Version - 20130723063200'" ' JavaScript String

Dim WithEvents oHTMLDoc As HTMLDocument
Attribute oHTMLDoc.VB_VarHelpID = -1
Dim WithEvents webBrowser As webBrowser
Attribute webBrowser.VB_VarHelpID = -1
Dim wbVer As Integer

Dim isCacheReadyForRead As Boolean
Dim isWindowWorkInProgress As Boolean

Dim isDebug As Boolean
Dim timerWatchmanCount As Integer

Private Sub cmdExit_Click()
    'Unload Me
    Call ScriptModule.TryExit(webBrowser)
End Sub

Private Sub Form_KeyPress(KeyAscii As Integer)
    If KeyAscii = vbKeyF5 Then
         KeyAscii = 0
    End If
End Sub

Private Sub Form_Load()

On Error GoTo START_FAILURE
    'Dim strArgs As String
    'strArgs = Command
    'If strArgs <> "go" Then
    '    MsgBox strArgs
    '    Unload Me
    '    Exit Sub
    'End If
    isDebug = ("true" = LCase(IniModule.INIRead("webkiter", "enable_webkit_debug", App.Path & "\configuration.ini")))
    timerWatchmanCount = 0
    wbVer = 1
    isCacheReadyForRead = False
    isWindowWorkInProgress = False
    Me.WindowState = vbMaximized
    Call WebBrowser1.Move(0, 0, Screen.Width \ Screen.TwipsPerPixelX - 0, Screen.Height \ Screen.TwipsPerPixelY - 0)
    WebBrowser1.Visible = False
    WebBrowser1.Silent = True
    WebBrowser1.RegisterAsBrowser = True
    Call WebBrowser2.Move(0, 0, Screen.Width \ Screen.TwipsPerPixelX - 0, Screen.Height \ Screen.TwipsPerPixelY - 0)
    WebBrowser2.Visible = False
    WebBrowser2.Silent = True
    WebBrowser2.RegisterAsBrowser = True
    
    Call ScriptModule.SetClientApplicationFlag(webBrowser, VERSION)
    Call cmdExit.Move(Screen.Width \ Screen.TwipsPerPixelX - 68, 20, 48, 36)
    
    If isDebug Then
        timerWatchman.Interval = 5000
    Else
        SetWindowPos hwnd, HWND_TOPMOST, 0, 0, 0, 0, TOPMOST_FLAGS
    End If
    timerWatchman.Enabled = True

    Set webBrowser = WebBrowser1
    'webBrowser.Navigate "http://www.baidu.com"
    webBrowser.Navigate IniModule.INIRead("webkiter", "homepage", App.Path & "\configuration.ini"), 4 'noCache = 4
    webBrowser.Visible = True
    
    Exit Sub
    
START_FAILURE:

    Err.Clear
    Call IOModule.WriteText(Err.Description, App.Path & "\error.log")
    Call IOModule.WriteText(Err.Number, App.Path & "\error.log")
    Call IOModule.WriteText(Err.Source, App.Path & "\error.log")
    

End Sub

Private Sub Form_LostFocus()
    Me.Show
End Sub

Private Sub timerWatchman_Timer()
On Error Resume Next
    timerWatchmanCount = timerWatchmanCount + 1

    Dim cache As String
    cache = ScriptModule.ReadScriptCache(webBrowser)
    If Len(cache) > 0 And isCacheReadyForRead Then
        'Call IniModule.INIWrite("webkiter", "script_cache", cache, App.Path & "\configuration.ini")
        'Do While True
        '    cache = cache & cache
        '    If Len(cache) > 80000 Then
        '        Exit Do
        '    End If
        'Loop
        Call IOModule.WriteText(cache, App.Path & "\configuration.dat")
    End If

    Me.cmdExit.Visible = ScriptModule.GetExitCommandVisible(webBrowser)
    
    If ScriptModule.ShouldEndNow(webBrowser) Then
        timerWatchman.Enabled = False
        Unload Me
        Exit Sub
    End If
    
    If Not isDebug Then
        Me.Show
    End If
End Sub

Private Sub webBrowser_BeforeNavigate2(ByVal pDisp As Object, URL As Variant, FLAGS As Variant, TargetFrameName As Variant, PostData As Variant, Headers As Variant, Cancel As Boolean)
    Me.txtAddress.text = URL

    If Not webBrowser Is Nothing And Not webBrowser.Document Is Nothing Then
        'webBrowser.Document.parentWindow.execScript ("document.getElementsByTagName('body')[0].innerHTML = '请求处理中……';")
    End If
End Sub

Private Sub webBrowser_NewWindow2(ppDisp As Object, Cancel As Boolean)
    If isWindowWorkInProgress Then
        Cancel = True
        Exit Sub
    End If

    'If wbVer = 1 Then
        'wbVer = 2
        'Set webBrowser = Me.WebBrowser2
        'Me.WebBrowser1.Visible = False
        'Me.WebBrowser2.Visible = True
    'Else
        'wbVer = 1
        'Set webBrowser = Me.WebBrowser1
        'Me.WebBrowser1.Visible = True
        'Me.WebBrowser2.Visible = False
    'End If
    
    isWindowWorkInProgress = True
    
    If webBrowser = Me.WebBrowser1 Then
        Set webBrowser = Me.WebBrowser2
    Else
        Set webBrowser = Me.WebBrowser1
    End If
    
    Set ppDisp = webBrowser.object
    
End Sub

Private Sub webBrowser_ProgressChange(ByVal Progress As Long, ByVal ProgressMax As Long)
On Error Resume Next
    If Progress > 0 And ProgressMax > 0 Then
        lblProgress.Caption = Int(Progress * 100 / ProgressMax) & "%"
    End If
    Exit Sub
End Sub

Private Sub webBrowser_NavigateComplete2(ByVal pDisp As Object, URL As Variant)
    Set oHTMLDoc = webBrowser.Document
    Call ScriptModule.SetClientApplicationFlag(webBrowser, VERSION)
    
    Call ScriptModule.DisableBrowserFresh(webBrowser)
    
    Dim cache As String
    'cache = IniModule.INIRead("webkiter", "script_cache", App.Path & "\configuration.ini")
    cache = IOModule.ReadText(App.Path & "\configuration.dat")
    Call ScriptModule.WriteScriptCache(webBrowser, cache)

    isCacheReadyForRead = True
    
    If isWindowWorkInProgress Then
        isWindowWorkInProgress = False
        If webBrowser = Me.WebBrowser1 Then
            Me.WebBrowser2.Visible = False
            webBrowser.Visible = True
        Else
            Me.WebBrowser1.Visible = False
            webBrowser.Visible = True
        End If
    End If
End Sub

Private Function oHTMLDoc_oncontextmenu() As Boolean
    ' Leave this event empty, but with some comment on it
End Function

' http://forums.devx.com/showthread.php?38506-Disable-Context-Menu-in-the-WebBrowser-Control





