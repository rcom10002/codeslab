Attribute VB_Name = "UIModule"
Private Type ControlPositionType
    Left As Single
    Top As Single
    Width As Single
    Height As Single
    FontSize As Single
End Type

Private m_ControlPositions() As ControlPositionType
Private m_FormWid As Single
Private m_FormHgt As Single
Public m_controls As Object

' Save the form's and controls' dimensions.
Public Sub SaveSizes()
Dim i As Integer
Dim ctl As Control

    ' Save the controls' positions and sizes.
    ReDim m_ControlPositions(1 To m_controls.Count)
    i = 1
    For Each ctl In m_controls
        With m_ControlPositions(i)
            If TypeOf ctl Is Line Then
                .Left = ctl.X1
                .Top = ctl.Y1
                .Width = ctl.X2 - ctl.X1
                .Height = ctl.Y2 - ctl.Y1
            Else
                .Left = ctl.Left
                .Top = ctl.Top
                .Width = ctl.Width
                .Height = ctl.Height
                On Error Resume Next
                .FontSize = ctl.Font.Size
                On Error GoTo 0
            End If
        End With
        i = i + 1
    Next ctl

    ' Save the form's size.
    m_FormWid = ScaleWidth
    m_FormHgt = ScaleHeight
End Sub

' Arrange the controls for the new size.
Public Sub ResizeControls()
Dim i As Integer
Dim ctl As Control
Dim x_scale As Single
Dim y_scale As Single

    ' Don't bother if we are minimized.
    If WindowState = vbMinimized Then Exit Sub

    ' Get the form's current scale factors.
    x_scale = ScaleWidth / m_FormWid
    y_scale = ScaleHeight / m_FormHgt

    ' Position the controls.
    i = 1
    For Each ctl In m_controls
        With m_ControlPositions(i)
            If TypeOf ctl Is Line Then
                ctl.X1 = x_scale * .Left
                ctl.Y1 = y_scale * .Top
                ctl.X2 = ctl.X1 + x_scale * .Width
                ctl.Y2 = ctl.Y1 + y_scale * .Height
            Else
                ctl.Left = x_scale * .Left
                ctl.Top = y_scale * .Top
                ctl.Width = x_scale * .Width
                If Not (TypeOf ctl Is ComboBox) Then
                    ' Cannot change height of ComboBoxes.
                    ctl.Height = y_scale * .Height
                End If
                On Error Resume Next
                ctl.Font.Size = y_scale * .FontSize
                On Error GoTo 0
            End If
        End With
        i = i + 1
    Next ctl
End Sub
