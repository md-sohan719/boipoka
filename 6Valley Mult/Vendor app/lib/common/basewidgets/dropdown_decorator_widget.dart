import 'package:flutter/material.dart';
import 'package:sixvalley_vendor_app/localization/language_constrants.dart';
import 'package:sixvalley_vendor_app/utill/dimensions.dart';
import 'package:sixvalley_vendor_app/utill/styles.dart';

class DropdownDecoratorWidget extends StatelessWidget {
  final String? title;
  final Widget child;
  final bool isRequired;
  const DropdownDecoratorWidget({super.key, this.title, required this.child, this.isRequired = false});

  @override
  Widget build(BuildContext context) {
    return Stack(children: [
      Padding(
        padding: const EdgeInsets.symmetric(vertical: Dimensions.paddingSizeSmall),
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: Dimensions.paddingSizeSmall),
          decoration: BoxDecoration(color: Theme.of(context).cardColor,
              borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
              border: Border.all(width: .5, color: Theme.of(context).primaryColor.withValues(alpha:.25))
          ),
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: Dimensions.paddingEye),
            child: child,
          ),
        ),
      ),

      (title?.isNotEmpty ?? false) ?
      Positioned(top: 0, left: Dimensions.paddingSizeMedium, child: Container(
        color: Theme.of(context).cardColor,
        padding: const EdgeInsets.symmetric(horizontal: Dimensions.paddingSizeExtraSmall),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text(getTranslated(title, context)!, style: robotoRegular.copyWith(color: Theme.of(context).textTheme.bodyLarge?.color)),
            if(isRequired)
            Text(' *', style: robotoRegular.copyWith(color: Theme.of(context).colorScheme.error, fontSize: Dimensions.fontSizeDefault))
          ],
        ),
      )) : const SizedBox.shrink(),
    ]);
  }
}
