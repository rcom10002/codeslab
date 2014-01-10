Attribute VB_Name = "DesktopModule"
Private Declare Function CreateDesktop Lib "user32" Alias "CreateDesktopW" ( _
      ByVal lpszDesktop As Long, _
      ByVal lpszDevice As Long, _
      pDevmode As Any, _
      ByVal dwFlags As Long, _
      ByVal dwDesiredAccess As Long, _
      lpsa As Any _
   ) As Long
Private Declare Function SwitchDesktop Lib "user32" (ByVal hDesktop As Long) As Long
Private Declare Function GetThreadDesktop Lib "user32" (ByVal dwThread As Long) As Long
Private Declare Function GetCurrentThreadId Lib "kernel32" () As Long
Private Declare Function OpenInputDesktop Lib "user32" ( _
      ByVal dwFlags As Long, _
      ByVal fInherit As Boolean, _
      ByVal dwDesiredAccess As Long _
   ) As Long
Private Const DESKTOP_SWITCHDESKTOP = &H100&
Private Const GENERIC_ALL = &H10000000


Private Type PROCESS_INFORMATION
   hProcess As Long
   hThread As Long
   dwProcessId As Long
   dwThreadId As Long
End Type

Private Type STARTUPINFOW
   cbSize As Long
   lpReserved As Long
   lpDesktop As Long
   lpTitle As Long
   dwX As Long
   dwY As Long
   dwXSize As Long
   dwYSize As Long
   dwXCountChars As Long
   dwYCountChars As Long
   dwFillAttribute As Long
   dwFlags As Long
   wShowWindow As Integer
   cbReserved2 As Integer
   lpReserved2 As Long
   hStdInput As Long
   hStdOutput As Long
   hStdError As Long
End Type

Private Declare Function CreateProcess Lib "kernel32" Alias "CreateProcessW" ( _
      ByVal lpApplicationName As Long, _
      ByVal lpCommandLine As Long, _
      lpProcessAttributes As Any, _
      lpThreadAttributes As Any, _
      ByVal bInheritHandles As Long, _
      ByVal dwCreationFlags As Long, _
      lpEnvironment As Any, _
      ByVal lpCurrentDirectory As Long, _
      lpStartupInfo As STARTUPINFOW, _
      lpProcessInformation As PROCESS_INFORMATION _
   ) As Long

